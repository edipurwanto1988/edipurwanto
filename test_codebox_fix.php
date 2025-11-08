<?php
/**
 * Test script to verify CodeBox fix
 * Run this to test the CodeBox functionality
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeBox Fix Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.css">
    <style>
        .test-result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">CodeBox Fix Verification</h1>
        
        <div id="testResults" class="mb-6">
            <div class="test-result info">
                <strong>Test Status:</strong> <span id="status">Initializing...</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">CKEditor Test Area</h2>
            <textarea name="content" id="content" rows="10" class="w-full border border-gray-300 rounded-lg px-3 py-2">
<p>Test the CodeBox functionality by clicking the "Code Box" button in the toolbar above.</p>
            </textarea>
            
            <div class="mt-4 space-x-3">
                <button onclick="runTests()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Run Tests
                </button>
                <button onclick="clearResults()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Clear Results
                </button>
            </div>
        </div>
    </div>

    <script>
        let testResults = [];
        
        function addTestResult(message, type = 'info') {
            testResults.push({ message, type, timestamp: new Date().toLocaleTimeString() });
            updateTestDisplay();
        }
        
        function updateTestDisplay() {
            const resultsDiv = document.getElementById('testResults');
            const statusSpan = document.getElementById('status');
            
            if (testResults.length > 0) {
                const latestResult = testResults[testResults.length - 1];
                statusSpan.textContent = latestResult.message;
                
                // Show last 5 results
                const recentResults = testResults.slice(-5);
                resultsDiv.innerHTML = recentResults.map(result => 
                    `<div class="test-result ${result.type}">
                        <strong>[${result.timestamp}]</strong> ${result.message}
                    </div>`
                ).join('');
            }
        }
        
        function clearResults() {
            testResults = [];
            updateTestDisplay();
        }
        
        function runTests() {
            addTestResult('Starting CodeBox tests...', 'info');
            
            // Test 1: Check ClassicEditor availability
            if (typeof ClassicEditor !== 'undefined') {
                addTestResult('✓ ClassicEditor is available', 'success');
            } else {
                addTestResult('✗ ClassicEditor is not available', 'error');
                return;
            }
            
            // Test 2: Check if CKEditor is initialized
            const editorElement = document.querySelector('.ck-editor__editable');
            if (editorElement) {
                addTestResult('✓ CKEditor appears to be initialized', 'success');
            } else {
                addTestResult('✗ CKEditor not found - waiting for initialization...', 'info');
                setTimeout(runTests, 2000);
                return;
            }
            
            // Test 3: Check toolbar
            const toolbar = document.querySelector('.ck-toolbar');
            if (toolbar) {
                addTestResult('✓ Toolbar found', 'success');
            } else {
                addTestResult('✗ Toolbar not found', 'error');
                return;
            }
            
            // Test 4: Check CodeBox button
            setTimeout(() => {
                const codeBoxButton = document.querySelector('.ck-codebox-btn');
                if (codeBoxButton) {
                    addTestResult('✓ CodeBox button found in toolbar', 'success');
                    
                    // Test 5: Test button functionality
                    codeBoxButton.click();
                    setTimeout(() => {
                        const modal = document.querySelector('[style*="position: fixed"]');
                        if (modal && modal.querySelector('#codebox-language')) {
                            addTestResult('✓ CodeBox dialog opens correctly', 'success');
                            
                            // Close the dialog
                            const cancelButton = modal.querySelector('#codebox-cancel');
                            if (cancelButton) {
                                cancelButton.click();
                                addTestResult('✓ CodeBox dialog can be closed', 'success');
                            }
                        } else {
                            addTestResult('✗ CodeBox dialog not found', 'error');
                        }
                    }, 500);
                } else {
                    addTestResult('✗ CodeBox button not found in toolbar', 'error');
                    
                    // Debug info
                    const buttons = toolbar.querySelectorAll('.ck-button');
                    addTestResult(`Found ${buttons.length} buttons in toolbar`, 'info');
                }
            }, 1000);
        }
        
        // Initialize CKEditor when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            addTestResult('DOM loaded, initializing CKEditor...', 'info');
            
            const contentTextarea = document.querySelector('#content');
            const editorContainer = document.createElement('div');
            editorContainer.id = 'content-editor';
            editorContainer.style.minHeight = '300px';
            contentTextarea.parentNode.insertBefore(editorContainer, contentTextarea.nextSibling);
            contentTextarea.style.display = 'none';
            
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
                    placeholder: 'Write your content here...',
                    htmlSupport: {
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
                    addTestResult('✓ CKEditor initialized successfully', 'success');
                    
                    // Set initial content
                    if (contentTextarea.value) {
                        editor.setData(contentTextarea.value);
                    }
                    
                    // Sync content
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        contentTextarea.value = data;
                    });
                    
                    // Load CodeBox utility
                    addTestResult('Loading CodeBox utility...', 'info');
                    const script = document.createElement('script');
                    script.src = '/js/ckeditor/codebox_fixed.js';
                    script.onload = function() {
                        addTestResult('✓ CodeBox script loaded', 'success');
                        
                        if (typeof window.initCodeBox === 'function') {
                            addTestResult('✓ initCodeBox function available', 'success');
                            
                            const codeBoxUtil = window.initCodeBox(editor);
                            if (codeBoxUtil) {
                                addTestResult('✓ CodeBox utility initialization started', 'success');
                            } else {
                                addTestResult('✗ CodeBox utility initialization failed', 'error');
                            }
                        } else {
                            addTestResult('✗ initCodeBox function not available', 'error');
                        }
                    };
                    script.onerror = function() {
                        addTestResult('✗ Failed to load CodeBox script', 'error');
                    };
                    document.head.appendChild(script);
                    
                })
                .catch(error => {
                    addTestResult(`✗ CKEditor initialization failed: ${error.message}`, 'error');
                });
        });
    </script>
</body>
</html>