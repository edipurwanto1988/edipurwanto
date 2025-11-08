<?php
// Check if article exists and debug the edit page
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;

echo "=== Debug Article Edit Page ===\n\n";

$articleId = '33273a5b-419f-4f9e-b425-347eccf4a13e';
echo "Checking article ID: $articleId\n";

try {
    $article = Article::find($articleId);
    
    if ($article) {
        echo "✅ Article found!\n";
        echo "Title: " . $article->title . "\n";
        echo "Slug: " . $article->slug . "\n";
        echo "Created: " . $article->createdAt . "\n";
        echo "Content length: " . strlen($article->content ?? '') . " characters\n";
        
        // Check if content has CodeBox
        if ($article->content && strpos($article->content, 'code-box') !== false) {
            echo "✅ Article contains CodeBox content\n";
        } else {
            echo "ℹ️ Article does not contain CodeBox content\n";
        }
        
        echo "\n=== Edit URL ===\n";
        echo "Edit URL: http://127.0.0.1:8000/adminku/articles/{$articleId}/edit\n";
        
    } else {
        echo "❌ Article NOT found with ID: $articleId\n";
        
        // Show available articles
        echo "\n=== Available Articles ===\n";
        $articles = Article::take(5)->get(['id', 'title', 'slug', 'createdAt']);
        
        if ($articles->count() > 0) {
            foreach ($articles as $article) {
                echo "ID: " . $article->id . "\n";
                echo "Title: " . $article->title . "\n";
                echo "Edit URL: http://127.0.0.1:8000/adminku/articles/" . $article->id . "/edit\n";
                echo "---\n";
            }
        } else {
            echo "No articles found in database.\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Database Connection ===\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    echo "Database: " . DB::connection()->getDatabaseName() . "\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n=== Authentication Check ===\n";
echo "Note: Admin routes require authentication.\n";
echo "Make sure you are logged in at: http://127.0.0.1:8000/login\n";
echo "Default login credentials may be needed.\n";

?>