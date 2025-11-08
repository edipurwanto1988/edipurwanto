<?php
// Simulate the article edit page without authentication for testing
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Direct CKEditor Test - Article Edit Simulation</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CKEditor CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.js" crossorigin="anonymous"></script>

<style>
.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
}

/* CodeBox Styling */
.code-box {
    position: relative;
    background: #1a1a1a;
    color: #f8f8f2;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin: 2rem 0;
    border: 1px solid #333;
}

.code-box .code-box-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #2d2d2d;
    padding: 12px 16px;
    border-bottom: 1px solid #444;
}

.code-box .code-box-controls {
    display: flex;
    gap: 8px;
}

.code-box .code-box-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.code-box .code-box-dot.red { background: #ff5f56; }
.code-box .code-box-dot.yellow { background: #ffbd2e; }
.code-box .code-box-dot.green { background: #27c93f; }

.code-box .code-box-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.code-box .code-box-language {
    color: #888;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.code-box .copy-btn {
    background: transparent;
    color: #888;
    border: 1px solid #555;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.code-box .copy-btn:hover {
    color: #fff;
    border-color: #777;
    background: rgba(255, 255, 255, 0.1);
}

.code-box pre {
    margin: 0;
    padding: 16px;
    overflow-x: auto;
    background: transparent;
    border: none;
}

.code-box code {
    background: transparent;
    border: none;
    font-family: 'Fira Code', 'Monaco', 'Consolas', 'Ubuntu Mono', monospace;
    font-size: 14px;
    line-height: 1.5;
    color: #f8f8f2;
}
</style>
</head>
<body class="font-display bg-gray-100 p-8">
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Direct CKEditor Test - Article Edit Simulation</h1>
    
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
        <strong>Testing Mode:</strong> This is a direct test of CKEditor without authentication.
        <br><small>If this works, the issue is with authentication or routing in the actual edit page.</small>
    </div>

    <!-- Status Panel -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Status</h2>
        <div id="status-panel">
            <div id="ckeditor-status">Checking CKEditor...</div>
            <div id="codebox-status">Checking CodeBox...</div>
            <div id="editor-status">Editor not initialized yet...</div>
        </div>
    </div>

    <!-- Article Edit Form Simulation -->
    <section class="bg-white dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
        <form method="POST" action="#">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input type="text" name="title" id="title" value="vv" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                            placeholder="Enter article title">
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                        <input type="text" name="slug" id="slug" value="4444" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                            placeholder="article-url-slug">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                        
                        <!-- Mode toggle buttons -->
                        <div class="btn-group mb-2" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <button type="button" id="visualModeBtn" class="btn btn-sm bg-orange-700 text-white border-orange-700 btn-ghost" style="padding: 0.125rem 0.25rem; font-size: 0.875rem; background-color: transparent; border-color: currentColor;">
                                <i class="fas fa-eye mr-1" style="margin-right: 0.25rem;"></i> Visual
                            </button>
                            <button type="button" id="htmlModeBtn" class="btn btn-sm bg-orange-700 text-white border-orange-700" style="padding: 0.125rem 0.25rem; font-size: 0.875rem; background-color: #c2410c; border-color: #c2410c; color: white;">
                                <i class="fas fa-code mr-1" style="margin-right: 0.25rem;"></i> HTML Code
                            </button>
                        </div>
                        
                        <textarea name="content" id="content" rows="15" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:text-white"
                            placeholder="Write your article content here...">This is test content for debugging CKEditor.</textarea>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Test Buttons -->
    <div class="bg-white p-6 rounded-lg shadow mt-6">
        <h2 class="text-xl font-semibold mb-4">Test Functions</h2>
        <div class="space-x-4">
            <button onclick="testCKEditor()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Test CKEditor</button>
            <button onclick="testCodeBox()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Test CodeBox</button>
            <button onclick="showConsole()" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Show Console</button>
            <button onclick="clearConsole()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Clear Console</button>
        </div>
    </div>

    <!-- Console Output -->
    <div id="console-panel" class="bg-black text-green-400 p-4 rounded-lg mt-6 font-mono text-sm" style="display: none;">
        <h3 class="text-white mb-2">Console Output:</h3>
        <div id="console-output"></div>
    </div>
</div>

<script>
// Console capture
const consoleOutput = document.getElementById('console-output');
const consolePanel = document.getElementById('console-panel');
const originalLog = console.log;
const originalError = console.error;
const originalWarn = console.warn;

function addConsoleMessage(type, ...args) {
    const timestamp = new Date().toLocaleTimeString();
    const message = args.map(arg => 
        typeof arg === 'object' ? JSON.stringify(arg, null, 2) : String(arg)
    ).join(' ');
    
    consoleOutput.innerHTML += `<div>[${timestamp}] ${type}: ${message}</div>`;
    consoleOutput.scrollTop = consoleOutput.scrollHeight;
}

console.log = function(...args) {
    originalLog.apply(console, args);
    addConsoleMessage('LOG', ...args);
};

console.error = function(...args) {
    originalError.apply(console, args);
    addConsoleMessage('ERROR', ...args);
};

console.warn = function(...args) {
    originalWarn.apply(console, args);
    addConsoleMessage('WARN', ...args);
};

function updateStatus() {
    const ckeditorStatus = document.getElementById('ckeditor-status');
    const codeboxStatus = document.getElementById('codebox-status');
    const editorStatus = document.getElementById('editor-status');
    
    if (typeof ClassicEditor !== 'undefined') {
        ckeditorStatus.innerHTML = '✅ ClassicEditor available';
        ckeditorStatus.className = 'text-green-600';
    } else {
        ckeditorStatus.innerHTML = '❌ ClassicEditor NOT available';
        ckeditorStatus.className = 'text-red-600';
    }
    
    const codeBoxButton = document.querySelector('.ck-codebox-btn');
    if (codeBoxButton) {
        codeboxStatus.innerHTML = '✅ CodeBox button found';
        codeboxStatus.className = 'text-green-600';
    } else {
        codeboxStatus.innerHTML = '❌ CodeBox button NOT found';
        codeboxStatus.className = 'text-red-600';
    }
    
    const editorElement = document.querySelector('#content-editor');
    if (editorElement && editorElement.style.display !== 'none') {
        editorStatus.innerHTML = '✅ CKEditor is visible';
        editorStatus.className = 'text-green-600';
    } else {
        editorStatus.innerHTML = '❌ CKEditor not visible';
        editorStatus.className = 'text-red-600';
    }
}

let editorInstance = null;

function initializeCKEditor() {
    console.log('[Test] Starting CKEditor initialization...');
    
    try {
        const contentTextarea = document.querySelector('#content');
        if (!contentTextarea) {
            console.error('[Test] Content textarea not found');
            return;
        }
        
        console.log('[Test] Content textarea found');
        
        // Create editor container
        const editorWrapper = document.createElement('div');
        editorWrapper.className = 'editor-wrapper';
        editorWrapper.style.position = 'relative';
        
        const editorContainer = document.createElement('div');
        editorContainer.id = 'content-editor';
        editorContainer.style.minHeight = '400px';
        editorContainer.style.display = 'none';
        
        // Create HTML source textarea
        const htmlSourceTextarea = document.createElement('textarea');
        htmlSourceTextarea.id = 'content-html-source';
        htmlSourceTextarea.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg font-mono text-sm';
        htmlSourceTextarea.rows = '15';
        htmlSourceTextarea.style.display = 'none';
        htmlSourceTextarea.style.position = 'absolute';
        htmlSourceTextarea.style.top = '0';
        htmlSourceTextarea.style.left = '0';
        htmlSourceTextarea.style.width = '100%';
        htmlSourceTextarea.style.height = '100%';
        
        // Insert wrapper
        contentTextarea.parentNode.insertBefore(editorWrapper, contentTextarea.nextSibling);
        editorWrapper.appendChild(editorContainer);
        editorWrapper.appendChild(htmlSourceTextarea);
        
        // Hide original textarea
        contentTextarea.style.display = 'none';
        contentTextarea.setAttribute('aria-hidden', 'true');
        contentTextarea.setAttribute('tabindex', '-1');
        
        console.log('[Test] Editor container created');
        
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
                console.log('[Test] ✅ CKEditor initialized successfully!');
                editorInstance = editor;
                
                // Show editor
                editorContainer.style.display = 'block';
                
                // Set initial content
                if (contentTextarea.value) {
                    editor.setData(contentTextarea.value);
                    console.log('[Test] Initial content set');
                }
                
                // Sync content
                editor.model.document.on('change:data', () => {
                    const data = editor.getData();
                    contentTextarea.value = data;
                    htmlSourceTextarea.value = data;
                });
                
                // Mode toggle functionality
                const visualModeBtn = document.getElementById('visualModeBtn');
                const htmlModeBtn = document.getElementById('htmlModeBtn');
                
                visualModeBtn.addEventListener('click', function() {
                    if (htmlSourceTextarea.style.display !== 'none') {
                        editor.setData(htmlSourceTextarea.value);
                        contentTextarea.value = htmlSourceTextarea.value;
                    }
                    editorContainer.style.display = 'block';
                    htmlSourceTextarea.style.display = 'none';
                    visualModeBtn.style.backgroundColor = 'transparent';
                    htmlModeBtn.style.backgroundColor = '#c2410c';
                });
                
                htmlModeBtn.addEventListener('click', function() {
                    const htmlContent = editor.getData();
                    htmlSourceTextarea.value = htmlContent;
                    contentTextarea.value = htmlContent;
                    editorContainer.style.display = 'none';
                    htmlSourceTextarea.style.display = 'block';
                    htmlModeBtn.style.backgroundColor = 'transparent';
                    visualModeBtn.style.backgroundColor = '#c2410c';
                });
                
                htmlSourceTextarea.addEventListener('input', function() {
                    contentTextarea.value = htmlSourceTextarea.value;
                });
                
                // Load CodeBox
                console.log('[Test] Loading CodeBox utility...');
                const codeboxScript = document.createElement('script');
                codeboxScript.src = 'public/js/ckeditor/codebox_widget.js';
                codeboxScript.onload = function() {
                    console.log('[Test] CodeBox utility loaded');
                    if (typeof window.initCodeBox === 'function') {
                        const codeBoxUtil = window.initCodeBox(editor);
                        console.log('[Test] CodeBox initialization started');
                        
                        setTimeout(() => {
                            const codeBoxButton = document.querySelector('.ck-codebox-btn');
                            if (codeBoxButton) {
                                console.log('[Test] ✅ CodeBox button found and ready!');
                            } else {
                                console.log('[Test] ❌ CodeBox button not found');
                            }
                            updateStatus();
                        }, 2000);
                    }
                };
                codeboxScript.onerror = function() {
                    console.error('[Test] Failed to load CodeBox utility');
                };
                document.head.appendChild(codeboxScript);
                
                updateStatus();
            })
            .catch(error => {
                console.error('[Test] ❌ CKEditor initialization failed:', error);
                console.error('[Test] Error stack:', error.stack);
                
                // Show textarea as fallback
                contentTextarea.style.display = 'block';
                contentTextarea.style.border = '2px solid #ef4444';
                contentTextarea.title = 'CKEditor failed to load. Using fallback textarea.';
                
                updateStatus();
            });
            
    } catch (error) {
        console.error('[Test] Error during CKEditor setup:', error);
        updateStatus();
    }
}

function testCKEditor() {
    console.log('[Test] Manual CKEditor test triggered...');
    if (typeof ClassicEditor !== 'undefined') {
        if (!editorInstance) {
            initializeCKEditor();
        } else {
            console.log('[Test] CKEditor already initialized');
        }
    } else {
        console.error('[Test] ClassicEditor not available');
    }
}

function testCodeBox() {
    console.log('[Test] Manual CodeBox test triggered...');
    const codeBoxButton = document.querySelector('.ck-codebox-btn');
    if (codeBoxButton) {
        codeBoxButton.click();
        console.log('[Test] CodeBox button clicked');
    } else {
        console.error('[Test] CodeBox button not found');
    }
}

function showConsole() {
    consolePanel.style.display = consolePanel.style.display === 'none' ? 'block' : 'none';
}

function clearConsole() {
    consoleOutput.innerHTML = '';
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('[Test] DOM loaded');
    
    setTimeout(() => {
        console.log('[Test] Checking CKEditor availability...');
        if (typeof ClassicEditor !== 'undefined') {
            console.log('[Test] ClassicEditor is available');
            initializeCKEditor();
        } else {
            console.error('[Test] ClassicEditor not available');
        }
        updateStatus();
    }, 1000);
    
    // Update status every 2 seconds
    setInterval(updateStatus, 2000);
});
</script>
</body>
</html>