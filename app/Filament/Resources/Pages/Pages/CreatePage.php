<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (array_key_exists('content_html', $data) && $data['content_html'] !== null) {
            $data['content'] = $data['content_html'];
        }

        unset($data['content_html']);

        return $data;
    }
}
