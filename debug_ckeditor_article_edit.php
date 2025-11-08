<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CKEditor Article Edit Debug ===\n\n";

// Test 1: Check if the article exists
echo "1. Checking article existence...\n";
$articleId = '33273a5b-419f-4f9e-b425-347eccf4a13e';
$article = \App\Models\Article::find($articleId);

if ($article) {
    echo "✅ Article found: " . $article->title . "\n";
    echo "   ID: " . $article->id . "\n";
    echo "   Slug: " . $article->slug . "\n";
    echo "   Created: " . $article->createdAt . "\n";
} else {
    echo "❌ Article NOT found with ID: $articleId\n";
    
    // Try to find any article to test with
    $anyArticle = \App\Models\Article::first();
    if ($anyArticle) {
        echo "🔄 Found alternative article for testing: " . $anyArticle->id . "\n";
        $articleId = $anyArticle->id;
        $article = $anyArticle;
    } else {
        echo "❌ No articles found in database\n";
        exit(1);
    }
}

echo "\n";

// Test 2: Check authentication requirements
echo "2. Checking authentication requirements...\n";
$editRoute = route('adminku.articles.edit', $article);
echo "   Edit route: $editRoute\n";

// Check if auth middleware is applied
$routeCollection = app('router')->getRoutes();
$editRouteObject = null;
foreach ($routeCollection as $route) {
    if ($route->uri() === 'adminku/articles/{article}/edit') {
        $editRouteObject = $route;
        break;
    }
}

if ($editRouteObject) {
    $middleware = $editRouteObject->middleware();
    echo "   Middleware applied: " . implode(', ', $middleware) . "\n";
    if (in_array('auth', $middleware)) {
        echo "   ⚠️  Authentication required for this route\n";
    }
} else {
    echo "   ❌ Could not find route object\n";
}

echo "\n";

// Test 3: Check CKEditor CDN availability
echo "3. Testing CKEditor CDN availability...\n";

$ckeditorUrls = [
    'https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.js',
    'https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js'
];

foreach ($ckeditorUrls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_NOBODY, true); // Just check if it exists
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        echo "   ✅ CKEditor CDN accessible: $url\n";
    } else {
        echo "   ❌ CKEditor CDN NOT accessible: $url (HTTP $httpCode)\n";
    }
}

echo "\n";

// Test 4: Check if required view files exist
echo "4. Checking view files...\n";

$viewFiles = [
    'layouts.admin.app' => 'resources/views/layouts/admin/app.blade.php',
    'admin.articles.edit' => 'resources/views/admin/articles/edit.blade.php'
];

foreach ($viewFiles as $viewName => $filePath) {
    if (file_exists($filePath)) {
        echo "   ✅ View file exists: $viewName\n";
    } else {
        echo "   ❌ View file missing: $viewName ($filePath)\n";
    }
}

echo "\n";

// Test 5: Check CodeBox widget files
echo "5. Checking CodeBox widget files...\n";

$codeBoxFiles = [
    'public/js/ckeditor/codebox_widget.js',
    'public/js/ckeditor/codebox_fixed.js'
];

foreach ($codeBoxFiles as $filePath) {
    if (file_exists($filePath)) {
        echo "   ✅ CodeBox file exists: $filePath\n";
    } else {
        echo "   ❌ CodeBox file missing: $filePath\n";
    }
}

echo "\n";

// Test 6: Simulate accessing the edit page
echo "6. Testing edit page access...\n";

try {
    // Create a mock request
    $request = Request::create("/adminku/articles/$articleId/edit", 'GET');
    
    // Create controller instance
    $controller = new \App\Http\Controllers\Admin\ArticleController();
    
    // Try to call the edit method
    $response = $controller->edit($article);
    
    if ($response instanceof \Illuminate\View\View) {
        echo "   ✅ Edit controller method executed successfully\n";
        echo "   View name: " . $response->getName() . "\n";
        
        // Check if the view has the required data
        $data = $response->getData();
        if (isset($data['article'])) {
            echo "   ✅ Article data passed to view\n";
        } else {
            echo "   ❌ Article data missing from view\n";
        }
        
        if (isset($data['categories'])) {
            echo "   ✅ Categories data passed to view\n";
        } else {
            echo "   ❌ Categories data missing from view\n";
        }
    } else {
        echo "   ❌ Unexpected response type: " . get_class($response) . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error accessing edit page: " . $e->getMessage() . "\n";
    echo "   Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n";

// Test 7: Check for JavaScript errors in the view
echo "7. Analyzing JavaScript in edit view...\n";

$editViewPath = 'resources/views/admin/articles/edit.blade.php';
if (file_exists($editViewPath)) {
    $content = file_get_contents($editViewPath);
    
    // Check for CKEditor initialization
    if (strpos($content, 'ClassicEditor') !== false) {
        echo "   ✅ CKEditor initialization code found\n";
    } else {
        echo "   ❌ CKEditor initialization code NOT found\n";
    }
    
    // Check for DOM ready event
    if (strpos($content, 'DOMContentLoaded') !== false) {
        echo "   ✅ DOM ready event listener found\n";
    } else {
        echo "   ❌ DOM ready event listener NOT found\n";
    }
    
    // Check for content textarea
    if (strpos($content, 'id="content"') !== false) {
        echo "   ✅ Content textarea found\n";
    } else {
        echo "   ❌ Content textarea NOT found\n";
    }
    
    // Check for error handling
    if (strpos($content, 'console.error') !== false) {
        echo "   ✅ Error handling code found\n";
    } else {
        echo "   ⚠️  Error handling code NOT found\n";
    }
}

echo "\n";

// Test 8: Generate test URL for manual testing
echo "8. Test URLs for manual verification...\n";
echo "   Edit page: http://127.0.0.1:8000/adminku/articles/$articleId/edit\n";
echo "   Login page: http://127.0.0.1:8000/login\n";

echo "\n=== Debug Summary ===\n";
echo "Based on the analysis, here are the most likely causes:\n\n";

echo "1. 🔄 AUTHENTICATION ISSUE (Most Likely):\n";
echo "   - The edit route requires authentication (middleware: auth)\n";
echo "   - User may not be logged in or session expired\n";
echo "   - CKEditor may be blocked by auth redirects\n\n";

echo "2. 🔄 JAVASCRIPT LOADING TIMING ISSUE (Second Most Likely):\n";
echo "   - CKEditor CDN may be slow to load\n";
echo "   - DOM ready event may fire before CKEditor is available\n";
echo "   - Fallback mechanism may not be working properly\n\n";

echo "3. 🔄 BROWSER CONSOLE ERRORS:\n";
echo "   - JavaScript errors preventing CKEditor initialization\n";
echo "   - Network issues blocking CDN access\n";
echo "   - CSS conflicts hiding the editor\n\n";

echo "=== Recommended Next Steps ===\n";
echo "1. Ensure you are logged in to the admin panel\n";
echo "2. Open browser developer tools and check console for errors\n";
echo "3. Check Network tab for failed CKEditor CDN requests\n";
echo "4. Verify the content textarea exists in the DOM\n";
echo "5. Look for '[CKEditor Debug]' messages in console\n\n";

echo "=== Manual Testing Instructions ===\n";
echo "1. Open: http://127.0.0.1:8000/login\n";
echo "2. Login with admin credentials\n";
echo "3. Navigate to: http://127.0.0.1:8000/adminku/articles/$articleId/edit\n";
echo "4. Open browser developer tools (F12)\n";
echo "5. Check Console tab for '[CKEditor Debug]' messages\n";
echo "6. Check Network tab for CKEditor CDN requests\n";
echo "7. Look for the content textarea with id='content'\n";
echo "8. Verify if mode toggle buttons appear above the textarea\n";

echo "\nDebug complete!\n";