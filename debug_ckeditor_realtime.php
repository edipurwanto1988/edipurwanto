<?php
// Simulate the article edit page environment for debugging
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Debug CKEditor Realtime</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CKEditor CDN with multiple fallbacks -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.js" crossorigin="anonymous"></script>

<!-- Fallback CDN -->
<script>
window.addEventListener('load', function() {
    if (typeof ClassicEditor === 'undefined') {
        console.log('[CKEditor Debug] Loading fallback CDN...');
        const fallbackScript = document.createElement('script');
        fallbackScript.src = 'https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js';
        fallbackScript.crossOrigin = 'anonymous';
        fallbackScript.onload = function() {
            console.log('[CKEditor Debug] Fallback CDN loaded successfully');
        };
        fallbackScript.onerror = function() {
            console.error('[CKEditor Debug] All CDN loading attempts failed');
        };
        document.head.appendChild(fallbackScript);
        
        const fallbackLink = document.createElement('link');
        fallbackLink.rel = 'stylesheet';
        fallbackLink.href = 'https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.css';
        fallbackLink.crossOrigin = 'anonymous';
        document.head.appendChild(fallbackLink);
    } else {
        console.log('[CKEditor Debug] Primary CDN loaded successfully');
    }
});
</script>

<style>
.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
}
</style>
</head>
<body class="font-display bg-gray-100 p-8">
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Debug CKEditor Realtime - Article Edit Simulation</h1>
    
    <!-- Debug Panel -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Debug Status</h2>
        <div id="debug-status" class="space-y-2">
            <div id="ckeditor-status">Checking CKEditor...</div>
            <div id="dom-status">Checking DOM...</div>
            <div id="error-status">Checking for errors...</div>
        </div>
    </div>

    <!-- Form Simulation -->
    <section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
        <form method="POST" action="#">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input type="text" name="title" id="title" value="Test Article" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                            placeholder="Enter article title">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                        <textarea name="content" id="content" rows="15" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                            placeholder="Write your article content here...">This is test content for debugging CKEditor.</textarea>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Console Output -->
    <div class="bg-black text-green-400 p-4 rounded-lg mt-6 font-mono text-sm">
        <h3 class="text-white mb-2">Console Output:</h3>
        <div id="console-output"></div>
    </div>
</div>

<script>
// Enhanced debugging
const debugOutput = document.getElementById('console-output');
const originalLog = console.log;
const originalError = console.error;
const originalWarn = console.warn;

function addToConsole(type, ...args) {
    const timestamp = new Date().toLocaleTimeString();
    const message = args.map(arg => 
        typeof arg === 'object' ? JSON.stringify(arg, null, 2) : String(arg)
    ).join(' ');
    
    debugOutput.innerHTML += `<div>[${timestamp}] ${type}: ${message}</div>`;
    debugOutput.scrollTop = debugOutput.scrollHeight;
}

console.log = function(...args) {
    originalLog.apply(console, args);
    addToConsole('LOG', ...args);
};

console.error = function(...args) {
    originalError.apply(console, args);
    addToConsole('ERROR', ...args);
};

console.warn = function(...args) {
    originalWarn.apply(console, args);
    addToConsole('WARN', ...args);
};

// Update debug status
function updateDebugStatus() {
    const ckeditorStatus = document.getElementById('ckeditor-status');
    const domStatus = document.getElementById('dom-status');
    const errorStatus = document.getElementById('error-status');
    
    // Check CKEditor
    if (typeof ClassicEditor !== 'undefined') {
        ckeditorStatus.innerHTML = '✅ ClassicEditor is available';
        ckeditorStatus.className = 'text-green-600';
    } else {
        ckeditorStatus.innerHTML = '❌ ClassicEditor is NOT available';
        ckeditorStatus.className = 'text-red-600';
    }
    
    // Check DOM elements
    const contentTextarea = document.getElementById('content');
    if (contentTextarea) {
        domStatus.innerHTML = '✅ Content textarea found';
        domStatus.className = 'text-green-600';
    } else {
        domStatus.innerHTML = '❌ Content textarea NOT found';
        domStatus.className = 'text-red-600';
    }
    
    // Check for errors
    const errorCount = debugOutput.querySelectorAll('div').length;
    if (errorCount > 0) {
        errorStatus.innerHTML = `⚠️ ${errorCount} console messages logged`;
        errorStatus.className = 'text-yellow-600';
    } else {
        errorStatus.innerHTML = '✅ No errors detected';
        errorStatus.className = 'text-green-600';
    }
}

// Start debugging
console.log('[Debug] Starting CKEditor debug session...');
console.log('[Debug] Current URL:', window.location.href);
console.log('[Debug] User agent:', navigator.userAgent);

document.addEventListener('DOMContentLoaded', function() {
    console.log('[Debug] DOM Content Loaded event fired');
    updateDebugStatus();
    
    // Check if CKEditor script loaded
    setTimeout(function() {
        console.log('[Debug] Checking CKEditor availability after 500ms delay...');
        console.log('[Debug] ClassicEditor type:', typeof ClassicEditor);
        console.log('[Debug] ClassicEditor object:', ClassicEditor);
        
        if (typeof ClassicEditor === 'undefined') {
            console.error('[Debug] CKEditor failed to load from CDN');
            console.log('[Debug] Attempting to manually load CKEditor...');
            
            // Try manual loading
            const script = document.createElement('script');
            script.src = 'https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js';
            script.onload = function() {
                console.log('[Debug] Manual CKEditor load successful');
                initializeCKEditor();
            };
            script.onerror = function() {
                console.error('[Debug] Manual CKEditor load failed');
            };
            document.head.appendChild(script);
        } else {
            console.log('[Debug] CKEditor is available, proceeding with initialization...');
            initializeCKEditor();
        }
        
        updateDebugStatus();
    }, 500);
});

function initializeCKEditor() {
    console.log('[Debug] Starting CKEditor initialization...');
    
    try {
        const contentTextarea = document.querySelector('#content');
        if (!contentTextarea) {
            console.error('[Debug] Content textarea not found');
            return;
        }
        
        console.log('[Debug] Content textarea found:', contentTextarea);
        console.log('[Debug] Textarea value:', contentTextarea.value);
        
        // Create editor container
        const editorWrapper = document.createElement('div');
        editorWrapper.className = 'editor-wrapper';
        editorWrapper.style.position = 'relative';
        
        const editorContainer = document.createElement('div');
        editorContainer.id = 'content-editor';
        editorContainer.style.minHeight = '400px';
        editorContainer.style.display = 'none';
        
        // Insert wrapper
        contentTextarea.parentNode.insertBefore(editorWrapper, contentTextarea.nextSibling);
        editorWrapper.appendChild(editorContainer);
        
        // Hide original textarea
        contentTextarea.style.display = 'none';
        contentTextarea.setAttribute('aria-hidden', 'true');
        contentTextarea.setAttribute('tabindex', '-1');
        
        console.log('[Debug] Editor container created and inserted');
        console.log('[Debug] Attempting to create CKEditor instance...');
        
        ClassicEditor
            .create(editorContainer, {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ],
                placeholder: 'Write your article content here...',
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                removePlugins: [
                    'Image',
                    'ImageCaption', 
                    'ImageStyle',
                    'ImageToolbar',
                    'LinkImage',
                    'MediaEmbed',
                    'CKFinder',
                    'CKFinderUploadAdapter',
                    'EasyImage',
                    'CloudServices'
                ]
            })
            .then(editor => {
                console.log('[Debug] ✅ CKEditor initialized successfully!');
                console.log('[Debug] Editor instance:', editor);
                console.log('[Debug] Editor UI element:', editor.ui.view.element);
                
                // Show editor
                editorContainer.style.display = 'block';
                
                // Set initial content
                if (contentTextarea.value) {
                    editor.setData(contentTextarea.value);
                    console.log('[Debug] Initial content set');
                }
                
                // Sync content
                editor.model.document.on('change:data', () => {
                    const data = editor.getData();
                    contentTextarea.value = data;
                });
                
                // Load CodeBox
                console.log('[Debug] Loading CodeBox utility...');
                const codeboxScript = document.createElement('script');
                codeboxScript.src = 'public/js/ckeditor/codebox_widget.js';
                codeboxScript.onload = function() {
                    console.log('[Debug] CodeBox utility loaded');
                    if (typeof window.initCodeBox === 'function') {
                        const codeBoxUtil = window.initCodeBox(editor);
                        console.log('[Debug] CodeBox initialization started');
                    }
                };
                codeboxScript.onerror = function() {
                    console.error('[Debug] Failed to load CodeBox utility');
                };
                document.head.appendChild(codeboxScript);
                
                updateDebugStatus();
            })
            .catch(error => {
                console.error('[Debug] ❌ CKEditor initialization failed:', error);
                console.error('[Debug] Error stack:', error.stack);
                
                // Show textarea as fallback
                contentTextarea.style.display = 'block';
                contentTextarea.style.border = '2px solid #ef4444';
                contentTextarea.title = 'CKEditor failed to load. Using fallback textarea.';
                
                updateDebugStatus();
            });
            
    } catch (error) {
        console.error('[Debug] Error during CKEditor setup:', error);
        updateDebugStatus();
    }
}

// Update status every 2 seconds
setInterval(updateDebugStatus, 2000);
</script>
</body>
</html>