<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ $baseUrl }}/</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach ($articles as $article)
        <url>
            <loc>{{ $baseUrl }}/artikel/{{ $article->slug }}</loc>
            <lastmod>{{ optional($article->updatedAt ?? $article->createdAt)->tz('UTC')->format('Y-m-d\TH:i:sP') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach ($pages ?? [] as $page)
        <url>
            <loc>{{ $baseUrl }}/pages/{{ $page->slug }}</loc>
            <lastmod>{{ optional($page->updated_at ?? $page->created_at)->tz('UTC')->format('Y-m-d\TH:i:sP') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
