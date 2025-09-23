<?php

namespace App\Support;

use Illuminate\Support\Str;

class ArticleContentHelper
{
    public static function extractHeadings(string $html): array
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);

        $headings = [];

        foreach ($dom->getElementsByTagName('h2') as $heading) {
            $text = trim($heading->textContent ?? '');
            if ($text === '') {
                continue;
            }

            $id = $heading->getAttribute('id');
            if ($id === '') {
                $id = Str::slug($text);
                $heading->setAttribute('id', $id);
            }

            $headings[] = [
                'id' => $id,
                'text' => $text,
            ];
        }

        return [
            'content' => static::domDocumentToHtml($dom),
            'headings' => $headings,
        ];
    }

    protected static function domDocumentToHtml(\DOMDocument $dom): string
    {
        $body = $dom->getElementsByTagName('body')->item(0);
        if (! $body) {
            return '';
        }

        $html = '';
        foreach ($body->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        return $html;
    }
}
