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
            ->whereNotNull('image_url')
            ->orderBy('id')
            ->chunkById($chunkSize, function ($articles) use (&$processed, &$deleted) {
                foreach ($articles as $article) {
                    $processed++;

                    // Since we're now using image_url only, we don't need to delete thumbnail_thumb_path
                    // This command can be simplified or repurposed for image_url processing

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
