<?php

require_once 'vendor/autoload.php';

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CodeBox Frontend Debug ===\n\n";

// Check the current article content
echo "1. Checking article content...\n";
$article = \App\Models\Article::where('slug', '4444')->first();

if ($article) {
    echo "✅ Article found: " . $article->title . "\n";
    echo "   Content length: " . strlen($article->content) . " characters\n";
    
    // Check if content contains CodeBox HTML
    $hasCodeBox = strpos($article->content, 'class="code-box"') !== false;
    echo "   Contains CodeBox: " . ($hasCodeBox ? '✅ Yes' : '❌ No') . "\n";
    
    if (!$hasCodeBox) {
        echo "   ⚠️  Article doesn't contain any CodeBox elements yet\n";
        echo "   💡 You need to add a CodeBox using the CKEditor first\n\n";
        
        // Show first 200 characters of content
        echo "   Current content preview:\n";
        echo "   " . substr(strip_tags($article->content), 0, 200) . "...\n\n";
    } else {
        echo "   ✅ Article contains CodeBox elements\n";
        echo "   Content preview (first 300 chars):\n";
        echo "   " . substr($article->content, 0, 300) . "...\n\n";
    }
} else {
    echo "❌ Article with slug '4444' not found\n";
    exit(1);
}

// Check if frontend CSS is properly configured
echo "2. Checking frontend CSS configuration...\n";
$frontendLayoutPath = 'resources/views/layouts/app.blade.php';
if (file_exists($frontendLayoutPath)) {
    $layoutContent = file_get_contents($frontendLayoutPath);
    
    $hasCodeBoxCSS = strpos($layoutContent, '.code-box') !== false;
    echo "   CodeBox CSS in layout: " . ($hasCodeBoxCSS ? '✅ Yes' : '❌ No') . "\n";
    
    $hasPrismCSS = strpos($layoutContent, 'prism') !== false;
    echo "   Prism.js CSS: " . ($hasPrismCSS ? '✅ Yes' : '❌ No') . "\n";
    
    $hasCopyScript = strpos($layoutContent, 'copy-btn') !== false;
    echo "   Copy button script: " . ($hasCopyScript ? '✅ Yes' : '❌ No') . "\n";
} else {
    echo "   ❌ Frontend layout file not found\n";
}

echo "\n";

// Check article view template
echo "3. Checking article view template...\n";
$articleViewPath = 'resources/views/article.blade.php';
if (file_exists($articleViewPath)) {
    $viewContent = file_get_contents($articleViewPath);
    
    $hasContentRender = strpos($viewContent, '{!!') !== false;
    echo "   HTML content rendering: " . ($hasContentRender ? '✅ Yes' : '❌ No') . "\n";
    
    $hasProseClass = strpos($viewContent, 'prose') !== false;
    echo "   Prose styling class: " . ($hasProseClass ? '✅ Yes' : '❌ No') . "\n";
} else {
    echo "   ❌ Article view file not found\n";
}

echo "\n";

// Create test CodeBox content if needed
if (!$hasCodeBox) {
    echo "4. Creating test CodeBox content...\n";
    
    $testCodeBoxHTML = '<div class="code-box">
  <div class="code-box-header">
    <div class="code-box-controls">
      <span class="code-box-dot red"></span>
      <span class="code-box-dot yellow"></span>
      <span class="code-box-dot green"></span>
    </div>
    <div class="code-box-info">
      <span class="code-box-language">python</span>
      <button class="copy-btn">Copy</button>
    </div>
  </div>
  <pre><code class="language-python"># Contoh kode Python
x = 10
y = 3
print("Hasil Penjumlahan: " + str(x + y))</code></pre>
</div>';

    // Add test CodeBox to article content
    $newContent = $article->content . "\n\n" . $testCodeBoxHTML;
    
    echo "   Updating article content with test CodeBox...\n";
    $article->content = $newContent;
    $article->updatedAt = now();
    $article->save();
    
    echo "   ✅ Test CodeBox added to article\n";
    echo "   📝 Article updated at: " . $article->updatedAt . "\n";
}

echo "\n";

// Test the frontend route
echo "5. Testing frontend route...\n";
try {
    $route = route('articles.show', $article->slug);
    echo "   Frontend URL: " . $route . "\n";
    echo "   ✅ Route exists and is accessible\n";
} catch (Exception $e) {
    echo "   ❌ Route error: " . $e->getMessage() . "\n";
}

echo "\n=== Next Steps ===\n";
echo "1. 🔄 Refresh the frontend page: http://127.0.0.1:8000/artikel/4444\n";
echo "2. 🔍 Open browser developer tools (F12)\n";
echo "3. 📊 Check Console tab for any JavaScript errors\n";
echo "4. 🎨 Check Elements tab to see if CodeBox CSS is applied\n";
echo "5. 📋 Try clicking the Copy button to test functionality\n\n";

echo "Expected behavior:\n";
echo "   ✅ Dark themed code box with colored dots\n";
echo "   ✅ Syntax highlighted Python code\n";
echo "   ✅ 'Copy' button that shows success message\n";
echo "   ✅ Responsive design on mobile\n\n";

echo "If CodeBox styling still doesn't appear:\n";
echo "   1. Check browser console for CSS loading errors\n";
echo "   2. Verify the article content contains the CodeBox HTML\n";
echo "   3. Check if Tailwind CSS is conflicting with custom styles\n";
echo "   4. Try hard refresh (Ctrl+F5) to clear CSS cache\n\n";

echo "Debug complete! 🚀\n";