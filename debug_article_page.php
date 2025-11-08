<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Article;
use Illuminate\Support\Facades\DB;

echo "=== Debug Article Page Issue ===\n\n";

// Test 1: Check if article with slug '4444' exists
echo "1. Checking article with slug '4444':\n";
$article = Article::where('slug', '4444')->first();

if ($article) {
    echo "✓ Article found!\n";
    echo "  ID: " . $article->id . "\n";
    echo "  Title: " . $article->title . "\n";
    echo "  Slug: " . $article->slug . "\n";
    echo "  Published At: " . ($article->publishedAt ? $article->publishedAt->format('Y-m-d H:i:s') : 'Not set') . "\n";
    echo "  Created At: " . ($article->createdAt ? $article->createdAt->format('Y-m-d H:i:s') : 'Not set') . "\n";
    echo "  Excerpt: " . ($article->excerpt ?: 'No excerpt') . "\n";
    echo "  Content length: " . strlen($article->content ?? '') . "\n";
} else {
    echo "✗ Article not found!\n";
}

echo "\n";

// Test 2: Check database connection
echo "2. Testing database connection:\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n";
} catch (\Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check article route logic
echo "3. Simulating route logic:\n";
try {
    $slug = '4444';
    $article = Article::query()->with('category')->where('slug', $slug)->firstOrFail();
    echo "✓ Route logic successful - article would be found\n";
} catch (\Exception $e) {
    echo "✗ Route logic failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Check date formatting
echo "4. Testing date formatting:\n";
if ($article) {
    $publishedAt = $article->publishedAt;
    $createdAt = $article->createdAt;
    
    echo "  Published At object: " . ($publishedAt ? get_class($publishedAt) : 'null') . "\n";
    echo "  Created At object: " . ($createdAt ? get_class($createdAt) : 'null') . "\n";
    
    if ($publishedAt) {
        echo "  Published At formatted: " . $publishedAt->translatedFormat('d M Y') . "\n";
        echo "  Published At relative: " . $publishedAt->diffForHumans() . "\n";
    }
    
    if ($createdAt) {
        echo "  Created At formatted: " . $createdAt->translatedFormat('d M Y') . "\n";
        echo "  Created At relative: " . $createdAt->diffForHumans() . "\n";
    }
}

echo "\n=== Debug Complete ===\n";