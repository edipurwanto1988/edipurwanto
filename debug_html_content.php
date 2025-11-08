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

echo "Original HTML:\n";
echo $testHtml . "\n\n";

// Simulate Laravel validation
$request = new \Illuminate\Http\Request();
$request->merge(['content' => $testHtml]);

echo "After Request merge:\n";
echo $request->get('content') . "\n\n";

// Test validation rules
$rules = ['content' => 'required'];
$validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

if ($validator->fails()) {
    echo "Validation failed:\n";
    print_r($validator->errors());
} else {
    echo "Validation passed\n";
    $validated = $validator->validated();
    echo "Validated content:\n";
    echo $validated['content'] . "\n\n";
}

// Test with string rule (old validation)
$rulesWithString = ['content' => 'required|string'];
$validator2 = \Illuminate\Support\Facades\Validator::make($request->all(), $rulesWithString);

if ($validator2->fails()) {
    echo "Validation with string rule failed:\n";
    print_r($validator2->errors());
} else {
    echo "Validation with string rule passed\n";
    $validated2 = $validator2->validated();
    echo "Validated content with string rule:\n";
    echo $validated2['content'] . "\n\n";
}

// Test if there are any global middleware that might strip HTML
echo "Checking for any HTML stripping functions...\n";
$stripped = strip_tags($testHtml);
echo "strip_tags() result:\n";
echo $stripped . "\n\n";

// Check htmlspecialchars
$encoded = htmlspecialchars($testHtml);
echo "htmlspecialchars() result:\n";
echo $encoded . "\n\n";