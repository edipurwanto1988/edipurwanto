<?php
/**
 * Comprehensive TinyMCE Debug Script
 * Identifies potential issues in the current implementation
 */

echo "=== Comprehensive TinyMCE Debug ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// Check 1: File Structure Analysis
echo "1. File Structure Analysis:\n";
$filesToCheck = [
    'resources/views/layouts/admin/app.blade.php' => 'Admin Layout',
    'resources/views/admin/pages/edit.blade.php' => 'Page Edit Form',
    'resources/views/admin/articles/edit.blade.php' => 'Article Edit Form'
];

foreach ($filesToCheck as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ $description: EXISTS\n";
        
        // Check for TinyMCE references
        $content = file_get_contents($file);
        if (strpos($content, 'tinymce') !== false) {
            echo "      - Contains TinyMCE references\n";
        }
        if (strpos($content, 'codesample') !== false) {
            echo "      - Contains Code Sample plugin\n";
        }
        if (strpos($content, 'prism') !== false) {
            echo "      - Contains Prism.js references\n";
        }
    } else {
        echo "   ❌ $description: MISSING\n";
    }
}
echo "\n";

// Check 2: Configuration Conflicts
echo "2. Configuration Conflicts Analysis:\n";
$adminLayout = file_get_contents('resources/views/layouts/admin/app.blade.php');

// Check for duplicate TinyMCE initialization
$tinymceInitCount = substr_count($adminLayout, 'tinymce.init');
if ($tinymceInitCount > 1) {
    echo "   ⚠️  Multiple TinyMCE.init calls detected: $tinymceInitCount\n";
} else {
    echo "   ✅ Single TinyMCE initialization\n";
}

// Check for duplicate selectors
$selectorCount = substr_count($adminLayout, 'selector:');
if ($selectorCount > 1) {
    echo "   ⚠️  Multiple selector configurations: $selectorCount\n";
} else {
    echo "   ✅ Single selector configuration\n";
}

// Check for conflicting event listeners
$domReadyCount = substr_count($adminLayout, 'DOMContentLoaded');
if ($domReadyCount > 1) {
    echo "   ⚠️  Multiple DOMContentLoaded listeners: $domReadyCount\n";
} else {
    echo "   ✅ Single DOMContentLoaded listener\n";
}
echo "\n";

// Check 3: Page Edit Form Specific Issues
echo "3. Page Edit Form Analysis:\n";
$pageEdit = file_get_contents('resources/views/admin/pages/edit.blade.php');

// Check for duplicate initialization
$pageTinymceInit = substr_count($pageEdit, 'tinymce.init');
if ($pageTinymceInit > 0) {
    echo "   ⚠️  Page form has its own TinyMCE initialization\n";
    echo "      - This may conflict with layout initialization\n";
} else {
    echo "   ✅ No conflicting TinyMCE initialization in page form\n";
}

// Check for selector conflicts
if (strpos($pageEdit, "selector: '#content'") !== false) {
    echo "   ⚠️  Page form uses same selector as layout\n";
    echo "      - This may cause double initialization\n";
}
echo "\n";

// Check 4: Potential Issues Identified
echo "4. Potential Issues Identified:\n";

// Issue 1: Double Initialization
if ($tinymceInitCount > 0 && $pageTinymceInit > 0) {
    echo "   🚨 CRITICAL: Double TinyMCE initialization detected\n";
    echo "      - Layout initializes TinyMCE for '.tinymce-editor'\n";
    echo "      - Page form initializes TinyMCE for '#content'\n";
    echo "      - This can cause conflicts and unpredictable behavior\n";
}

// Issue 2: Selector Mismatch
if (strpos($adminLayout, "selector: 'textarea.tinymce-editor'") !== false && 
    strpos($pageEdit, "selector: '#content'") !== false) {
    echo "   🚨 CRITICAL: Selector mismatch detected\n";
    echo "      - Layout expects '.tinymce-editor' class\n";
    echo "      - Page form targets '#content' ID directly\n";
    echo "      - Content textarea may not get the class added\n";
}

// Issue 3: Configuration Conflicts
$layoutPlugins = [];
$pagePlugins = [];

// Extract plugins from layout
if (preg_match("/plugins:\s*\[([^\]]+)\]/", $adminLayout, $matches)) {
    $layoutPlugins = array_map('trim', explode(',', str_replace("'", "", $matches[1])));
}

// Extract plugins from page
if (preg_match("/plugins:\s*\[([^\]]+)\]/", $pageEdit, $matches)) {
    $pagePlugins = array_map('trim', explode(',', str_replace("'", "", $matches[1])));
}

if (!empty($layoutPlugins) && !empty($pagePlugins)) {
    $diff = array_diff($pagePlugins, $layoutPlugins);
    if (!empty($diff)) {
        echo "   ⚠️  Plugin configuration mismatch:\n";
        foreach ($diff as $plugin) {
            echo "      - Page form has plugin: $plugin\n";
        }
    }
}
echo "\n";

// Check 5: Recommended Solutions
echo "5. Recommended Solutions:\n";

if ($tinymceInitCount > 0 && $pageTinymceInit > 0) {
    echo "   🔧 SOLUTION 1: Remove duplicate initialization\n";
    echo "      - Keep initialization in layout only\n";
    echo "      - Remove tinymce.init from page forms\n";
    echo "      - Add 'tinymce-editor' class to content textareas\n";
}

if (strpos($adminLayout, "selector: 'textarea.tinymce-editor'") !== false && 
    strpos($pageEdit, "selector: '#content'") !== false) {
    echo "   🔧 SOLUTION 2: Fix selector mismatch\n";
    echo "      - Option A: Change layout to '#content'\n";
    echo "      - Option B: Add class to content textarea\n";
    echo "      - Option C: Use multiple selectors in layout\n";
}

echo "   🔧 SOLUTION 3: Standardize configuration\n";
echo "      - Move all TinyMCE config to layout\n";
echo "      - Use consistent plugin list\n";
echo "      - Use consistent toolbar configuration\n";
echo "\n";

echo "=== IMMEDIATE ACTIONS NEEDED ===\n";
echo "1. Choose single initialization approach\n";
echo "2. Fix selector conflicts\n";
echo "3. Standardize configuration\n";
echo "4. Test with both page and article forms\n";
echo "5. Verify code sample plugin works\n";