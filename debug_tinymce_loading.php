<?php
/**
 * Debug TinyMCE Loading Issues
 * Check for potential loading problems
 */

echo "=== TinyMCE Loading Debug ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Check 1: Verify TinyMCE CDN accessibility from server
echo "1. TinyMCE CDN Accessibility Test:\n";
$cdnUrl = 'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js';
$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'method' => 'HEAD'
    ]
]);

$ch = curl_init($cdnUrl);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "   ✅ CDN accessible (HTTP $httpCode)\n";
} else {
    echo "   ❌ CDN not accessible (HTTP $httpCode)\n";
    echo "      This is likely the root cause!\n";
}
echo "\n";

// Check 2: Analyze current article edit form
echo "2. Article Edit Form Analysis:\n";
$articleEdit = file_get_contents('resources/views/admin/articles/edit.blade.php');

// Check for tinymce-editor class
if (strpos($articleEdit, 'tinymce-editor') !== false) {
    echo "   ✅ tinymce-editor class found in textarea\n";
} else {
    echo "   ❌ tinymce-editor class NOT found in textarea\n";
}

// Check for duplicate initialization
if (strpos($articleEdit, 'tinymce.init') !== false) {
    echo "   ⚠️  tinymce.init still found in article form\n";
} else {
    echo "   ✅ No duplicate tinymce.init in article form\n";
}

// Check for DOMContentLoaded
if (strpos($articleEdit, 'DOMContentLoaded') !== false) {
    echo "   ⚠️  DOMContentLoaded still found in article form\n";
} else {
    echo "   ✅ No DOMContentLoaded conflicts in article form\n";
}
echo "\n";

// Check 3: Layout configuration
echo "3. Layout Configuration Analysis:\n";
$adminLayout = file_get_contents('resources/views/layouts/admin/app.blade.php');

// Check TinyMCE script loading
if (strpos($adminLayout, 'tinymce.min.js') !== false) {
    echo "   ✅ TinyMCE script loaded in layout\n";
} else {
    echo "   ❌ TinyMCE script NOT found in layout\n";
}

// Check configuration object
if (strpos($adminLayout, 'window.TinyMCEConfig') !== false) {
    echo "   ✅ TinyMCEConfig object found\n";
} else {
    echo "   ❌ TinyMCEConfig object NOT found\n";
}

// Check initialization
if (strpos($adminLayout, 'tinymce.init(window.TinyMCEConfig)') !== false) {
    echo "   ✅ TinyMCE initialization found\n";
} else {
    echo "   ❌ TinyMCE initialization NOT found\n";
}

// Check selector
if (strpos($adminLayout, "selector: 'textarea.tinymce-editor'") !== false) {
    echo "   ✅ Correct selector configured\n";
} else {
    echo "   ❌ Incorrect selector configuration\n";
}
echo "\n";

// Check 4: Potential Issues
echo "4. Potential Loading Issues:\n";

// Check for network blocking
echo "   🔍 Checking for common issues:\n";
echo "      - CDN accessibility: " . ($httpCode === 200 ? "✅" : "❌") . "\n";
echo "      - API key usage: Using 'no-api-key' (may have limitations)\n";
echo "      - Network dependency: Requires internet connection\n";
echo "      - Browser compatibility: Modern browsers required\n";

// Check for timing issues
if (strpos($adminLayout, 'DOMContentLoaded') !== false) {
    echo "      - DOM ready handling: ✅ Implemented\n";
} else {
    echo "      - DOM ready handling: ❌ Missing\n";
}

// Check for error handling
if (strpos($adminLayout, 'console.error') !== false) {
    echo "      - Error handling: ✅ Implemented\n";
} else {
    echo "      - Error handling: ❌ Missing\n";
}
echo "\n";

echo "=== DIAGNOSIS ===\n";
if ($httpCode !== 200) {
    echo "🚨 PRIMARY ISSUE: TinyMCE CDN not accessible from server\n";
    echo "   This explains why TinyMCE doesn't load in browser\n";
    echo "   \n";
    echo "   SOLUTIONS:\n";
    echo "   1. Check internet connection on server\n";
    echo "   2. Use alternative CDN or self-host TinyMCE\n";
    echo "   3. Get TinyMCE API key for better reliability\n";
} else {
    echo "🔍 CDN is accessible, issue may be:\n";
    echo "   1. Browser network blocking\n";
    echo "   2. JavaScript errors preventing initialization\n";
    echo "   3. Timing issues with DOM loading\n";
    echo "   4. Conflicts with other scripts\n";
}

echo "\n=== IMMEDIATE ACTIONS ===\n";
echo "1. Test TinyMCE CDN in browser directly\n";
echo "2. Check browser console for JavaScript errors\n";
echo "3. Verify network requests in browser dev tools\n";
echo "4. Test with alternative CDN if needed\n";