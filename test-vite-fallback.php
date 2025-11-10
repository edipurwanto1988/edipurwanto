<?php

// Test script for Vite fallback functionality
require_once __DIR__ . '/vendor/autoload.php';

use App\Support\ViteFallback;

echo "Testing Vite Fallback Solution\n";
echo "==============================\n\n";

// Test 1: Check if manifest exists
echo "1. Checking if Vite manifest exists...\n";
if (ViteFallback::manifestExists()) {
    echo "✅ Manifest file exists\n";
} else {
    echo "❌ Manifest file not found (this is expected for testing fallback)\n";
}

// Test 2: Generate fallback manifest
echo "\n2. Testing fallback manifest generation...\n";
if (ViteFallback::generateManifest()) {
    echo "✅ Fallback manifest generated successfully\n";
} else {
    echo "ℹ️  Manifest already exists\n";
}

// Test 3: Test Vite fallback functionality
echo "\n3. Testing Vite fallback with CSS asset...\n";
try {
    $vite = ViteFallback::withFallback(['resources/css/app.css']);
    echo "✅ Vite fallback loaded successfully\n";
    
    // Test asset URL generation
    $cssUrl = $vite->asset('resources/css/app.css');
    echo "✅ CSS URL generated: $cssUrl\n";
} catch (Exception $e) {
    echo "❌ Error testing Vite fallback: " . $e->getMessage() . "\n";
}

// Test 4: Test Vite fallback with JS asset
echo "\n4. Testing Vite fallback with JS asset...\n";
try {
    $vite = ViteFallback::withFallback(['resources/js/app.js']);
    echo "✅ Vite fallback loaded successfully\n";
    
    // Test asset URL generation
    $jsUrl = $vite->asset('resources/js/app.js');
    echo "✅ JS URL generated: $jsUrl\n";
} catch (Exception $e) {
    echo "❌ Error testing Vite fallback: " . $e->getMessage() . "\n";
}

// Test 5: Test with both assets
echo "\n5. Testing Vite fallback with both CSS and JS assets...\n";
try {
    $vite = ViteFallback::withFallback(['resources/css/app.css', 'resources/js/app.js']);
    echo "✅ Vite fallback loaded successfully\n";
    
    // Test asset URL generation
    $cssUrl = $vite->asset('resources/css/app.css');
    $jsUrl = $vite->asset('resources/js/app.js');
    echo "✅ CSS URL generated: $cssUrl\n";
    echo "✅ JS URL generated: $jsUrl\n";
} catch (Exception $e) {
    echo "❌ Error testing Vite fallback: " . $e->getMessage() . "\n";
}

echo "\n==============================\n";
echo "Test completed!\n";
echo "If all tests passed, the Vite fallback solution is working correctly.\n";