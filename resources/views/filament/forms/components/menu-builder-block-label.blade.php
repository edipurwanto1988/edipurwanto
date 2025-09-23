@php
    $state = $state ?? [];
    $data = $state['data'] ?? $state;
    $type = $state['type'] ?? ($data['type'] ?? null);

    $label = $data['label'] ?? null;

    if (! $label) {
        if ($type === 'page') {
            $label = $pageTitle ?? 'Link Page';
        } elseif ($type === 'custom') {
            $label = $data['url'] ?? 'Link Kustom';
        }
    }

    $label ??= 'Item Menu';
@endphp

<span class="fi-fo-builder-item-header-label fi-truncated">
    {{ $label }}
</span>
