<?php

namespace App\Support;

use Illuminate\Support\Str;

class ArticleContentHelper
{
    /**
     * Helper function to find heading in array by ID
     */
    private static function findHeadingInArray(&$array, $id) {
        foreach ($array as &$item) {
            if ($item['id'] === $id) {
                return $item;
            }
            if (!empty($item['children'])) {
                $found = static::findHeadingInArray($item['children'], $id);
                if ($found !== null) {
                    return $found;
                }
            }
        }
        return null;
    }

    public static function extractHeadings(string $html): array
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);

        $headings = [];

        // Extract all heading levels (h1 through h6)
        for ($level = 1; $level <= 6; $level++) {
            $elements = $dom->getElementsByTagName('h' . $level);
            foreach ($elements as $heading) {
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
                    'level' => $level,
                    'id' => $id,
                    'text' => $text,
                ];
            }
        }

        // Sort headings by their position in the document
        usort($headings, function ($a, $b) {
            // This is a simple sort by level first, then by position
            return $a['level'] <=> $b['level'];
        });

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
