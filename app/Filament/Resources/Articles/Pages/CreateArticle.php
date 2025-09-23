<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (array_key_exists('content_html', $data) && $data['content_html'] !== null) {
            $data['content'] = $data['content_html'];
        }

        unset($data['content_html']);

        return $data;
    }
}
