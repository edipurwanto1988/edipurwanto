<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportWordPressArticles extends Command
{
    protected $signature = 'wordpress:import {--force : Update existing articles when slugs match} {--limit= : Limit number of posts imported} {--no-progress : Disable progress bar output}';

    protected $description = 'Import posts and media from a WordPress database into local articles';

    protected string $wpPrefix;

    protected string $uploadsPath;

    protected array $tableCache = [];

    public function handle(): int
    {
        $prefix = env('WP_DB_PREFIX', 'wp_');
        $this->wpPrefix = $prefix !== '' ? rtrim($prefix, '_') : '';
        $this->uploadsPath = base_path('wp-content/uploads');

        if (! is_dir($this->uploadsPath)) {
            $this->error("Uploads directory not found at {$this->uploadsPath}. Place wp-content/uploads here first.");
            return self::FAILURE;
        }

        $this->info('Starting WordPress import…');

        $wp = DB::connection('wp');

        DB::connection()->transaction(function () use ($wp) {
            $this->importCategories($wp);
        });

        $force = (bool) $this->option('force');
        $limit = $this->option('limit');

        $showProgress = ! $this->option('no-progress');

        $imported = $this->importPosts($wp, $force, $limit, $showProgress);

        $this->info("Import finished: {$imported['created']} created, {$imported['updated']} updated, {$imported['skipped']} skipped.");

        if ($imported['missing_media']) {
            $this->warn("Missing media files: {$imported['missing_media']}");
        }

        $this->newLine();
        $this->line('Sumber tabel WordPress: '.($this->wpPrefix !== '' ? $this->wpPrefix.'*' : 'tanpa prefix (Langsung)'));

        return self::SUCCESS;
    }

    protected function wpTable(string $name): string
    {
        if (isset($this->tableCache[$name])) {
            return $this->tableCache[$name];
        }

        $candidates = [];

        if ($this->wpPrefix !== '') {
            $candidates[] = $this->wpPrefix.'_'.$name;
        }

        $candidates[] = $name;

        foreach ($candidates as $candidate) {
            if ($this->wpTableExists($candidate)) {
                return $this->tableCache[$name] = $candidate;
            }
        }

        return $this->tableCache[$name] = $candidates[0];
    }

    protected function wpTableExists(string $table): bool
    {
        try {
            return DB::connection('wp')->getSchemaBuilder()->hasTable($table);
        } catch (\Throwable $exception) {
            report($exception);

            return false;
        }
    }

    protected function importCategories($wp): void
    {
        $categories = $wp->table($this->wpTable('terms').' as t')
            ->join($this->wpTable('term_taxonomy').' as tt', 'tt.term_id', '=', 't.term_id')
            ->where('tt.taxonomy', 'category')
            ->select([
                't.term_id',
                't.name',
                't.slug',
                'tt.description',
            ])
            ->orderBy('t.name')
            ->get();

        $this->info('Syncing categories…');

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category->slug],
                [
                    'name' => $category->name,
                    'description' => $category->description,
                ]
            );
        }

        $this->info("Categories synced: {$categories->count()}");
    }

    protected function importPosts($wp, bool $force, ?int $limit, bool $showProgress): array
    {
        $query = $wp->table($this->wpTable('posts'))
            ->where('post_type', 'post')
            ->whereIn('post_status', ['publish'])
            ->orderBy('ID');

        if ($limit) {
            $query->limit((int) $limit);
        }

        $created = $updated = $skipped = $missingMedia = 0;

        $total = (clone $query)->count();
        $bar = $showProgress ? $this->output->createProgressBar($total) : null;

        if ($bar) {
            $bar->start();
        }

        $query->chunkById(50, function ($posts) use (&$created, &$updated, &$skipped, &$missingMedia, $wp, $force, $bar) {
            $postIds = $posts->pluck('ID');

            $categoryMap = $this->fetchPostCategories($wp, $postIds);
            $thumbnailMap = $this->fetchPostThumbnails($wp, $postIds);

            foreach ($posts as $post) {
                [$article, $status, $missing] = $this->upsertArticle($post, $categoryMap, $thumbnailMap, $force);

                $created += $status === 'created' ? 1 : 0;
                $updated += $status === 'updated' ? 1 : 0;
                $skipped += $status === 'skipped' ? 1 : 0;
                $missingMedia += $missing ? 1 : 0;

                if ($bar) {
                    $bar->advance();
                }
            }
        }, 'ID');

        if ($bar) {
            $bar->finish();
            $this->newLine(2);
        } else {
            $this->newLine();
        }

        return compact('created', 'updated', 'skipped') + ['missing_media' => $missingMedia];
    }

    protected function fetchPostCategories($wp, $postIds): array
    {
        if ($postIds->isEmpty()) {
            return [];
        }

        $relationships = $wp->table($this->wpTable('term_relationships').' as tr')
            ->join($this->wpTable('term_taxonomy').' as tt', 'tt.term_taxonomy_id', '=', 'tr.term_taxonomy_id')
            ->whereIn('tr.object_id', $postIds)
            ->where('tt.taxonomy', 'category')
            ->select([
                'tr.object_id as post_id',
                'tt.term_id',
            ])
            ->orderBy('tr.object_id')
            ->get()
            ->groupBy('post_id');

        $localCategories = Category::pluck('id', 'slug');

        $wpTerms = DB::connection('wp')->table($this->wpTable('terms'))
            ->whereIn('term_id', $relationships->flatten()->pluck('term_id')->unique())
            ->pluck('slug', 'term_id');

        $map = [];

        foreach ($relationships as $postId => $items) {
            $termId = Arr::first($items)->term_id ?? null;
            if (! $termId) {
                continue;
            }

            $slug = $wpTerms[$termId] ?? null;
            if (! $slug) {
                continue;
            }

            $map[$postId] = $localCategories[$slug] ?? null;
        }

        return $map;
    }

    protected function fetchPostThumbnails($wp, $postIds): array
    {
        if ($postIds->isEmpty()) {
            return [];
        }

        $meta = $wp->table($this->wpTable('postmeta'))
            ->whereIn('post_id', $postIds)
            ->where('meta_key', '_thumbnail_id')
            ->pluck('meta_value', 'post_id');

        if ($meta->isEmpty()) {
            return [];
        }

        $attachmentIds = $meta->values()->unique();

        $files = $wp->table($this->wpTable('postmeta'))
            ->whereIn('post_id', $attachmentIds)
            ->where('meta_key', '_wp_attached_file')
            ->pluck('meta_value', 'post_id');

        $result = [];

        foreach ($meta as $postId => $attachmentId) {
            $result[$postId] = $files[$attachmentId] ?? null;
        }

        return $result;
    }

    protected function upsertArticle($post, array $categoryMap, array $thumbnailMap, bool $force): array
    {
        $baseSlug = $this->normalizeSlug($post->post_name ?: $post->post_title);

        $existing = Article::where('slug', $baseSlug)->first();
        $slug = $existing?->slug ?? $this->generateUniqueSlug($baseSlug);

        if ($existing && ! $force) {
            return [$existing, 'skipped', false];
        }

        $data = [
            'title' => $post->post_title ?: 'Tanpa Judul',
            'excerpt' => $this->resolveExcerpt($post),
            'content' => $post->post_content,
            'published_at' => $this->resolvePublishedAt($post),
            'category_id' => $categoryMap[$post->ID] ?? null,
        ];

        [$thumbnailPaths, $missingMedia] = $this->persistThumbnail($post, $thumbnailMap[$post->ID] ?? null);
        $data += $thumbnailPaths;

        if ($existing) {
            $existing->fill($data);
            $existing->save();

            return [$existing, 'updated', $missingMedia];
        }

        $article = Article::create(array_merge($data, ['slug' => $slug]));

        return [$article, 'created', $missingMedia];
    }

    protected function persistThumbnail($post, ?string $relativePath): array
    {
        if (! $relativePath) {
            return [
                [
                    'thumbnail_path' => null,
                    'thumbnail_url' => null,
                    'thumbnail_thumb_path' => null,
                ],
                false,
            ];
        }

        $source = $this->uploadsPath.'/'.$relativePath;

        if (! is_file($source)) {
            $this->warn("Missing media file for post ID {$post->ID}: {$relativePath}");
            return [
                [
                    'thumbnail_path' => null,
                    'thumbnail_url' => null,
                    'thumbnail_thumb_path' => null,
                ],
                true,
            ];
        }

        $extension = pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg';
        $targetDirectory = 'articles/'.Carbon::parse($post->post_date ?: now())->format('Y/m');
        $targetFile = $targetDirectory.'/'.Str::uuid().'.'.$extension;

        Storage::disk('public')->put($targetFile, file_get_contents($source));

        return [
            [
                'thumbnail_path' => $targetFile,
                'thumbnail_url' => $targetFile,
                'thumbnail_thumb_path' => null,
            ],
            false,
        ];
    }

    protected function resolveExcerpt($post): string
    {
        if ($post->post_excerpt) {
            return $post->post_excerpt;
        }

        return Str::limit(strip_tags($post->post_content ?? ''), 280);
    }

    protected function resolvePublishedAt($post): ?Carbon
    {
        if (! $post->post_date) {
            return null;
        }

        if ($post->post_date === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return Carbon::parse($post->post_date);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function normalizeSlug(?string $value): string
    {
        $slug = Str::slug($value ?? '');

        return $slug !== '' ? $slug : Str::uuid()->toString();
    }

    protected function generateUniqueSlug(string $base): string
    {
        $slug = $base;

        $original = $slug;
        $counter = 1;

        while (Article::where('slug', $slug)->exists()) {
            $counter++;
            $slug = $original.'-'.$counter;
        }

        return $slug;
    }
}
