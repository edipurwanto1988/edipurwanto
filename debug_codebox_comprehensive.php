<?php
/**
 * Comprehensive CodeBox Debug Script
 * This script helps diagnose why CodeBox is not displaying on the article edit page
 */

// Include Laravel bootstrap if needed
require_once __DIR__ . '/vendor/autoload.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create debug HTML page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeBox Debug - Article Edit Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.css">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .debug-panel {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 400px;
            max-height: 80vh;
            overflow-y: auto;
            background: #1a1a1a;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 12px;
            z-index: 10000;
        }
        .debug-log {
            margin-bottom: 5px;
            padding: 5px;
            border-radius: 3px;
        }
        .debug-success { background: #10b981; }
        .debug-error { background: #ef4444; }
        .debug-info { background: #3b82f6; }
        .debug-warning { background: #f59e0b; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">CodeBox Debug - Article Edit Page Simulation</h1>
        
        <!-- Debug Panel -->
        <div class="debug-panel" id="debugPanel">
            <h3 class="text-lg font-bold mb-3">Debug Console</h3>
            <div id="debugLogs"></div>
            <button onclick="clearDebugLogs()" class="mt-3 bg-red-600 text-white px-3 py-1 rounded text-sm">Clear Logs</button>
        </div>

        <!-- Simulated Article Edit Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2" value="Test Article">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content" id="content" rows="15" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Write your article content here...">
<p>This is a test article with some content.</p>
<pre><code class="language-python">def hello_world():
    print("Hello, World!")
    return True</code></pre>
<p>More content here...</p>
                    </textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="testCodeBoxInsertion()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Test CodeBox Insertion
                    </button>
                    <button type="button" onclick="checkCKEditorState()" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                        Check CKEditor State
                    </button>
                    <button type="button" onclick="inspectToolbar()" class="bg-purple-600 text-white px-4 py-2 rounded-lg">
                        Inspect Toolbar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Debug logging function
        function debugLog(message, type = 'info') {
            const debugLogs = document.getElementById('debugLogs');
            const logEntry = document.createElement('div');
            logEntry.className = `debug-log debug-${type}`;
            logEntry.innerHTML = `[${new Date().toLocaleTimeString()}] ${message}`;
            debugLogs.appendChild(logEntry);
            debugLogs.scrollTop = debugLogs.scrollHeight;
            console.log(`[Debug] ${message}`);
        }

        function clearDebugLogs() {
            document.getElementById('debugLogs').innerHTML = '';
        }

        // Enhanced CKEditor initialization with comprehensive debugging
        document.addEventListener('DOMContentLoaded', function() {
            debugLog('DOM loaded, starting CKEditor initialization...', 'info');
            
            // Check if ClassicEditor is available
            if (typeof ClassicEditor === 'undefined') {
                debugLog('ERROR: ClassicEditor is not available!', 'error');
                return;
            }
            debugLog('ClassicEditor is available', 'success');
            
            const contentTextarea = document.querySelector('#content');
            if (!contentTextarea) {
                debugLog('ERROR: Content textarea not found!', 'error');
                return;
            }
            debugLog('Content textarea found', 'success');
            
            // Create editor container
            const editorContainer = document.createElement('div');
            editorContainer.id = 'content-editor';
            editorContainer.style.minHeight = '400px';
            contentTextarea.parentNode.insertBefore(editorContainer, contentTextarea.nextSibling);
            contentTextarea.style.display = 'none';
            
            // Initialize CKEditor with detailed configuration
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
                    heading: [
                        { model: 'paragraph', title: 'Paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3' }
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
                    generalHtmlSupport: {
                        allow: [
                            {
                                name: /.*/,
                                attributes: true,
                                classes: true,
                                styles: true
                            }
                        ]
                    }
                })
                .then(editor => {
                    debugLog('CKEditor initialized successfully', 'success');
                    debugLog(`Editor instance: ${typeof editor}`, 'info');
                    debugLog(`Editor UI: ${typeof editor.ui}`, 'info');
                    debugLog(`Editor UI view: ${typeof editor.ui.view}`, 'info');
                    
                    // Set initial content
                    if (contentTextarea.value) {
                        editor.setData(contentTextarea.value);
                        debugLog('Initial content set', 'success');
                    }
                    
                    // Sync content
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        contentTextarea.value = data;
                    });
                    
                    // Load CodeBox utility with enhanced error handling
                    debugLog('Loading CodeBox utility...', 'info');
                    const script = document.createElement('script');
                    script.src = '/js/ckeditor/codebox.js';
                    script.onload = function() {
                        debugLog('CodeBox script loaded successfully', 'success');
                        
                        // Check if initCodeBox function exists
                        if (typeof window.initCodeBox === 'function') {
                            debugLog('initCodeBox function found', 'success');
                            
                            try {
                                const codeBoxUtil = window.initCodeBox(editor);
                                if (codeBoxUtil) {
                                    debugLog('CodeBox utility initialized successfully', 'success');
                                    debugLog(`CodeBox instance: ${typeof codeBoxUtil}`, 'info');
                                    
                                    // Store reference for manual testing
                                    window.debugCodeBox = codeBoxUtil;
                                } else {
                                    debugLog('ERROR: CodeBox utility initialization returned null', 'error');
                                }
                            } catch (error) {
                                debugLog(`ERROR: CodeBox initialization failed: ${error.message}`, 'error');
                                debugLog(`Stack: ${error.stack}`, 'error');
                            }
                        } else {
                            debugLog('ERROR: initCodeBox function not found after loading script', 'error');
                        }
                    };
                    script.onerror = function() {
                        debugLog('ERROR: Failed to load CodeBox script', 'error');
                    };
                    document.head.appendChild(script);
                    
                    // Store editor reference for debugging
                    window.debugEditor = editor;
                    
                })
                .catch(error => {
                    debugLog(`ERROR: CKEditor initialization failed: ${error.message}`, 'error');
                    debugLog(`Stack: ${error.stack}`, 'error');
                });
        });

        // Test functions for manual debugging
        function testCodeBoxInsertion() {
            if (window.debugCodeBox) {
                debugLog('Testing CodeBox insertion...', 'info');
                const result = window.debugCodeBox.insertCodeBox('javascript', '// Test code\nconsole.log("Hello World");');
                debugLog(`CodeBox insertion result: ${result}`, result ? 'success' : 'error');
            } else {
                debugLog('ERROR: CodeBox utility not available', 'error');
            }
        }

        function checkCKEditorState() {
            if (window.debugEditor) {
                debugLog('CKEditor State Check:', 'info');
                debugLog(`Editor exists: ${!!window.debugEditor}`, 'info');
                debugLog(`Editor UI exists: ${!!window.debugEditor.ui}`, 'info');
                debugLog(`Editor UI view exists: ${!!window.debugEditor.ui.view}`, 'info');
                debugLog(`Editor element exists: ${!!window.debugEditor.ui.view.element}`, 'info');
                
                const editorElement = window.debugEditor.ui.view.element;
                if (editorElement) {
                    debugLog(`Editor element tag: ${editorElement.tagName}`, 'info');
                    debugLog(`Editor element classes: ${editorElement.className}`, 'info');
                    
                    // Look for toolbar
                    const toolbar = editorElement.querySelector('.ck-toolbar');
                    debugLog(`Toolbar found: ${!!toolbar}`, toolbar ? 'success' : 'warning');
                    if (toolbar) {
                        debugLog(`Toolbar classes: ${toolbar.className}`, 'info');
                        debugLog(`Toolbar children count: ${toolbar.children.length}`, 'info');
                    }
                    
                    // Look for CodeBox button
                    const codeBoxBtn = editorElement.querySelector('.ck-codebox-btn');
                    debugLog(`CodeBox button found: ${!!codeBoxBtn}`, codeBoxBtn ? 'success' : 'warning');
                }
            } else {
                debugLog('ERROR: CKEditor not available', 'error');
            }
        }

        function inspectToolbar() {
            if (window.debugEditor) {
                const editorElement = window.debugEditor.ui.view.element;
                if (editorElement) {
                    const toolbar = editorElement.querySelector('.ck-toolbar');
                    if (toolbar) {
                        debugLog('Toolbar Inspection:', 'info');
                        debugLog(`Toolbar HTML: ${toolbar.outerHTML.substring(0, 200)}...`, 'info');
                        
                        // List all buttons
                        const buttons = toolbar.querySelectorAll('.ck-button');
                        debugLog(`Found ${buttons.length} buttons in toolbar`, 'info');
                        buttons.forEach((btn, index) => {
                            debugLog(`Button ${index}: ${btn.className} - ${btn.textContent.trim()}`, 'info');
                        });
                    } else {
                        debugLog('ERROR: Toolbar not found', 'error');
                    }
                }
            } else {
                debugLog('ERROR: CKEditor not available', 'error');
            }
        }

        // Auto-start debugging
        debugLog('Debug page loaded successfully', 'success');
        debugLog('Waiting for CKEditor initialization...', 'info');
    </script>
</body>
</html>