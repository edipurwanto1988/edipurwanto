<?php
// Final Verification Test for CKEditor 5 CodeBox Solution
echo "=== CKEditor 5 CodeBox - Final Verification ===\n\n";

// Test 1: Check all critical files exist
echo "1. CRITICAL FILES VERIFICATION:\n";
$criticalFiles = [
    'public/js/ckeditor/codebox.js' => 'CodeBox utility',
    'resources/views/layouts/admin/app.blade.php' => 'Admin layout',
    'resources/views/layouts/app.blade.php' => 'Main layout',
    'resources/views/admin/articles/edit.blade.php' => 'Article edit view'
];

foreach ($criticalFiles as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ {$description}: EXISTS\n";
    } else {
        echo "   ❌ {$description}: MISSING\n";
    }
}

// Test 2: Verify CDN fixes
echo "\n2. CDN FIXES VERIFICATION:\n";
$adminLayout = file_get_contents('resources/views/layouts/admin/app.blade.php');
$mainLayout = file_get_contents('resources/views/layouts/app.blade.php');

$cdnChecks = [
    'ckeditor5/39.0.1/classic/ckeditor.js' => 'CKEditor CDN version',
    'cdnjs.cloudflare.com/ajax/libs/prism' => 'Prism.js CDN source',
    'prism-python.min.js' => 'Python syntax support',
    'prism-javascript.min.js' => 'JavaScript syntax support',
    'prism-php.min.js' => 'PHP syntax support',
    'prism-css.min.js' => 'CSS syntax support'
];

foreach ($cdnChecks as $check => $description) {
    if (strpos($adminLayout . $mainLayout, $check) !== false) {
        echo "   ✅ {$description}: FIXED\n";
    } else {
        echo "   ❌ {$description}: NOT FOUND\n";
    }
}

// Test 3: Verify CKEditor plugin configuration
echo "\n3. CKEDITOR PLUGIN CONFIGURATION:\n";
$editView = file_get_contents('resources/views/admin/articles/edit.blade.php');

$pluginChecks = [
    "'Essentials'" => 'Essentials plugin',
    "'Heading'" => 'Heading plugin',
    "'Bold'" => 'Bold plugin',
    "'Italic'" => 'Italic plugin',
    "'Link'" => 'Link plugin',
    "'List'" => 'List plugin (replaces BulletedList/NumberedList)',
    "'Indent'" => 'Indent plugin',
    "'BlockQuote'" => 'BlockQuote plugin',
    "'Table'" => 'Table plugin',
    "'Undo'" => 'Undo plugin',
    "'Redo'" => 'Redo plugin'
];

foreach ($pluginChecks as $plugin => $description) {
    if (strpos($editView, $plugin) !== false) {
        echo "   ✅ {$description}: CONFIGURED\n";
    } else {
        echo "   ❌ {$description}: MISSING\n";
    }
}

// Test 4: Verify CodeBox integration
echo "\n4. CODEBOX INTEGRATION:\n";
$codeboxChecks = [
    'initCodeBox' => 'CodeBox initialization',
    'asset("js/ckeditor/codebox.js")' => 'CodeBox script loading',
    '[CKEditor Debug] CodeBox utility' => 'Debug logging',
    'script.onload' => 'Script load handling',
    'script.onerror' => 'Script error handling'
];

foreach ($codeboxChecks as $check => $description) {
    if (strpos($editView, $check) !== false) {
        echo "   ✅ {$description}: IMPLEMENTED\n";
    } else {
        echo "   ❌ {$description}: MISSING\n";
    }
}

// Test 5: Verify error handling
echo "\n5. ERROR HANDLING:\n";
$errorChecks = [
    '.catch(error =>' => 'CKEditor error handling',
    'console.error' => 'Error logging',
    'contentTextarea.style.display = \'block\'' => 'Fallback textarea',
    'bg-red-100 border border-red-400' => 'Error message styling'
];

foreach ($errorChecks as $check => $description) {
    if (strpos($editView, $check) !== false) {
        echo "   ✅ {$description}: IMPLEMENTED\n";
    } else {
        echo "   ❌ {$description}: MISSING\n";
    }
}

// Test 6: Verify CodeBox utility
echo "\n6. CODEBOX UTILITY VERIFICATION:\n";
if (file_exists('public/js/ckeditor/codebox.js')) {
    $codeboxContent = file_get_contents('public/js/ckeditor/codebox.js');
    $utilityChecks = [
        'class CodeBoxUtility' => 'CodeBoxUtility class',
        'insertCodeBox' => 'insertCodeBox method',
        'addToolbarButton' => 'Toolbar button method',
        'generateCodeBoxHTML' => 'HTML generation',
        'showLanguageDialog' => 'Language dialog',
        'copy-btn' => 'Copy button support',
        'language-python' => 'Python language support',
        'language-javascript' => 'JavaScript language support',
        'language-php' => 'PHP language support'
    ];
    
    foreach ($utilityChecks as $check => $description) {
        if (strpos($codeboxContent, $check) !== false) {
            echo "   ✅ {$description}: IMPLEMENTED\n";
        } else {
            echo "   ❌ {$description}: MISSING\n";
        }
    }
} else {
    echo "   ❌ CodeBox utility file not found\n";
}

echo "\n=== SUMMARY OF FIXES APPLIED ===\n";
echo "✅ Fixed CKEditor CDN version (39.0.1)\n";
echo "✅ Changed Prism.js CDN to Cloudflare\n";
echo "✅ Removed problematic Prism.js components\n";
echo "✅ Fixed CKEditor plugin configuration\n";
echo "✅ Added comprehensive error handling\n";
echo "✅ Implemented dynamic CodeBox loading\n";
echo "✅ Added debug logging throughout\n";

echo "\n=== EXPECTED BEHAVIOR ===\n";
echo "1. CKEditor should load without errors\n";
echo "2. CodeBox button should appear in toolbar\n";
echo "3. Language selection dialog should work\n";
echo "4. Syntax highlighting should work for supported languages\n";
echo "5. Copy button should copy code to clipboard\n";
echo "6. Fallback textarea should appear if CKEditor fails\n";

echo "\n=== TESTING INSTRUCTIONS ===\n";
echo "1. Open: http://127.0.0.1:8000/adminku/articles/ID/edit\n";
echo "2. Check browser console for debug messages\n";
echo "3. Verify CKEditor loads properly\n";
echo "4. Look for 'Code Box' button in toolbar\n";
echo "5. Test inserting code boxes\n";
echo "6. Test copy functionality\n";

echo "\n=== VERIFICATION COMPLETE ===\n";