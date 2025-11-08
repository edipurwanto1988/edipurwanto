<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test the exact HTML that the user is trying to save
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

echo "=== Testing HTML Preservation ===\n\n";

// Simulate the exact request that would come from the form
$request = new \Illuminate\Http\Request();
$request->merge([
    'title' => 'Test Article',
    'slug' => 'test-article',
    'content' => $testHtml,
    'excerpt' => 'Test excerpt'
]);

echo "1. Original HTML length: " . strlen($testHtml) . " characters\n";
echo "First 100 chars: " . substr($testHtml, 0, 100) . "...\n\n";

// Test validation with the new rules
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'slug' => 'required|string|max:255',
    'content' => 'required',
    'excerpt' => 'nullable|string',
]);

echo "2. After validation - HTML length: " . strlen($validated['content']) . " characters\n";
echo "First 100 chars: " . substr($validated['content'], 0, 100) . "...\n\n";

// Test if HTML is preserved
if ($validated['content'] === $testHtml) {
    echo "✅ HTML is preserved through validation\n";
} else {
    echo "❌ HTML was modified during validation\n";
    echo "Differences:\n";
    echo "Original: " . $testHtml . "\n";
    echo "Validated: " . $validated['content'] . "\n";
}

// Test creating an article
try {
    $article = new \App\Models\Article();
    $article->id = \Illuminate\Support\Str::uuid()->toString();
    $article->title = $validated['title'];
    $article->slug = $validated['slug'];
    $article->content = $validated['content'];
    $article->excerpt = $validated['excerpt'];
    $article->createdAt = now();
    $article->updatedAt = now();
    
    echo "3. After model assignment - HTML length: " . strlen($article->content) . " characters\n";
    echo "First 100 chars: " . substr($article->content, 0, 100) . "...\n\n";
    
    if ($article->content === $testHtml) {
        echo "✅ HTML is preserved in model\n";
    } else {
        echo "❌ HTML was modified in model\n";
    }
    
    // Actually save to test database
    $article->save();
    
    echo "4. After saving to database - HTML length: " . strlen($article->content) . " characters\n";
    echo "First 100 chars: " . substr($article->content, 0, 100) . "...\n\n";
    
    if ($article->content === $testHtml) {
        echo "✅ HTML is preserved after database save\n";
    } else {
        echo "❌ HTML was modified after database save\n";
    }
    
    // Clean up
    $article->delete();
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";