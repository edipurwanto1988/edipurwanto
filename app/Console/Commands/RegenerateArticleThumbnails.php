<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RegenerateArticleThumbnails extends Command
{
    protected $signature = 'articles:regenerate-thumbnails {--chunk=100 : Number of articles to process per chunk}';

    protected $description = 'Regenerate article thumbnail crops at the latest target size.';

    public function handle(): int
    {
        $chunkSize = (int) $this->option('chunk');

        $this->info('Regenerating article thumbnails…');

        $processed = 0;
        $deleted = 0;

        Article::query()
            ->whereNotNull('thumbnail_path')
            ->orderBy('id')
            ->chunkById($chunkSize, function ($articles) use (&$processed, &$deleted) {
                foreach ($articles as $article) {
                    $processed++;

                    if ($article->thumbnail_thumb_path && Storage::disk('public')->exists($article->thumbnail_thumb_path)) {
                        Storage::disk('public')->delete($article->thumbnail_thumb_path);
                        $deleted++;
                    }

                    $article->forceFill(['thumbnail_thumb_path' => null])->save();

                    // Touch accessor to trigger regeneration via ensureThumbnailGenerated().
                    $article->refresh();
                    $article->thumbnail_thumb_url;

                    $this->output->write('.');
                }
            });

        $this->newLine(2);
        $this->info("Processed: {$processed} articles");
        $this->info("Old thumbnails removed: {$deleted}");

        return self::SUCCESS;
    }
}
