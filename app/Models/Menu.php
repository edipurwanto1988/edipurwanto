<?php

namespace App\Models;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'items',
        'url',
        'page_id',
        'target',
        'order',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
    ];

    public function getResolvedItemsAttribute(): Collection
    {
        $items = collect($this->items ?? []);

        if ($items->isEmpty()) {
            return collect();
        }

        $pageIds = $items
            ->filter(fn ($item) => ($item['type'] ?? '') === 'page')
            ->pluck('data.page_id')
            ->filter()
            ->unique();

        $pages = Page::query()
            ->whereIn('id', $pageIds)
            ->get()
            ->keyBy('id');

        return $items->map(function ($item) use ($pages) {
            $type = $item['type'] ?? 'custom';
            $data = $item['data'] ?? [];

            if ($type === 'page') {
                $page = $pages->get($data['page_id'] ?? null);

                if (! $page) {
                    return null;
                }

                return [
                    'label' => $data['label'] ?? $page->title,
                    'url' => route('pages.show', $page->slug),
                    'open_in_new_tab' => (bool) ($data['open_in_new_tab'] ?? false),
                ];
            }

            if ($type === 'custom') {
                $url = $data['url'] ?? null;

                if (! $url) {
                    return null;
                }

                return [
                    'label' => $data['label'] ?? Str::of($url)->replace(['http://', 'https://'], '')->limit(30),
                    'url' => $url,
                    'open_in_new_tab' => (bool) ($data['open_in_new_tab'] ?? false),
                ];
            }

            return null;
        })->filter();
    }
    
    /**
     * Get the page associated with the menu item.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
 