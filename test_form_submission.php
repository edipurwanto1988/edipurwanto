<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test HTML content
$testHtml = '<pre id="codeBlock" class="p-4 overflow-x-auto text-sm">
<span class="text-blue-400"># Contoh operasi aritmatika</span>
x = <span class="text-yellow-400">10</span>
y = <span class="text-yellow-400">3</span>

tambah = x + y
kurang = x - y
kali = x * y
bagi = x / y
modulus = x % y

<span class="text-green-400">print</span>(<span class="text-rose-300">f"Hasil Penjumlahan: {tambah}"</span>)
<span class="text-green-400">print</span>(<span class="text-rose-300">f"Hasil Pembagian: {bagi}"</span>)
</pre>';

echo "=== Testing Form Submission Simulation ===\n\n";

// Simulate POST request like the browser would send
$_POST['content'] = $testHtml;
$_POST['title'] = 'Test Article';
$_POST['slug'] = 'test-article';

$request = \Illuminate\Http\Request::capture();
$request->merge($_POST);

echo "1. Original content from POST:\n";
echo $request->get('content') . "\n\n";

// Test validation exactly like in ArticleController
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'slug' => 'required|string|max:255',
    'content' => 'required',
]);

echo "2. After validation:\n";
echo $validated['content'] . "\n\n";

// Test creating an article to see if the model strips anything
try {
    $article = new \App\Models\Article();
    $article->id = \Illuminate\Support\Str::uuid()->toString();
    $article->title = $validated['title'];
    $article->slug = $validated['slug'];
    $article->content = $validated['content'];
    $article->createdAt = now();
    $article->updatedAt = now();
    
    echo "3. Content before saving to model:\n";
    echo $article->content . "\n\n";
    
    // Don't actually save, just test the model assignment
    echo "4. Model attributes:\n";
    echo "Content: " . $article->getAttributes()['content'] . "\n\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test if there are any PHP settings that might strip HTML
echo "5. PHP settings check:\n";
echo "magic_quotes_gpc: " . (ini_get('magic_quotes_gpc') ? 'ON' : 'OFF') . "\n";
echo "magic_quotes_runtime: " . (ini_get('magic_quotes_runtime') ? 'ON' : 'OFF') . "\n\n";

// Test different ways the content might be processed
echo "6. Testing different processing methods:\n";
echo "Original length: " . strlen($testHtml) . "\n";
echo "After strip_tags: " . strlen(strip_tags($testHtml)) . "\n";
echo "After htmlspecialchars: " . strlen(htmlspecialchars($testHtml)) . "\n";
echo "After htmlentities: " . strlen(htmlentities($testHtml)) . "\n\n";