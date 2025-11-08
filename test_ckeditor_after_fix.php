<!DOCTYPE html>
<html>
<head>
    <title>Test CKEditor After Syntax Fix</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CKEditor CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.4.0/build/ckeditor.js" crossorigin="anonymous"></script>
    
    <!-- CodeBox CSS -->
    <style>
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
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Test CKEditor After Syntax Fix</h1>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">CKEditor Test Area</h2>
            
            <!-- Mode toggle buttons -->
            <div class="btn-group mb-2" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                <button type="button" id="visualModeBtn" class="btn btn-sm bg-orange-700 text-white border-orange-700 btn-ghost" style="padding: 0.125rem 0.25rem; font-size: 0.875rem; background-color: transparent; border-color: currentColor;">
                    <i class="fas fa-eye mr-1" style="margin-right: 0.25rem;"></i> Visual
                </button>
                <button type="button" id="htmlModeBtn" class="btn btn-sm bg-orange-700 text-white border-orange-700" style="padding: 0.125rem 0.25rem; font-size: 0.875rem; background-color: #c2410c; border-color: #c2410c; color: white;">
                    <i class="fas fa-code mr-1" style="margin-right: 0.25rem;"></i> HTML Code
                </button>
            </div>
            
            <!-- Editor container -->
            <div class="editor-wrapper" style="position: relative;">
                <textarea id="content" name="content" rows="15" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Test content here..."></textarea>
                <div id="content-editor" style="min-height: 400px; display: none;"></div>
                <textarea id="content-html-source" class="w-full px-3 py-2 border border-gray-300 rounded-lg font-mono text-sm" rows="15" style="display: none; margin: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></textarea>
            </div>
            
            <div class="mt-4">
                <button onclick="testCodeBox()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Test CodeBox Insertion</button>
                <button onclick="showDebugInfo()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">Show Debug Info</button>
            </div>
        </div>
        
        <div id="debug-info" class="bg-white p-6 rounded-lg shadow mt-6" style="display: none;">
            <h2 class="text-xl font-semibold mb-4">Debug Information</h2>
            <div id="debug-content"></div>
        </div>
    </div>

    <script>
        console.log('[Test] Starting CKEditor test after syntax fix...');
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('[Test] DOM loaded, initializing CKEditor...');
            
            setTimeout(function() {
                if (typeof ClassicEditor !== 'undefined') {
                    console.log('[Test] ClassicEditor is available, initializing...');
                    
                    const contentTextarea = document.querySelector('#content');
                    const editorContainer = document.querySelector('#content-editor');
                    const htmlSourceTextarea = document.querySelector('#content-html-source');
                    
                    // Hide original textarea
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
                            console.log('[Test] CKEditor initialized successfully');
                            
                            // Load CodeBox utility
                            const script = document.createElement('script');
                            script.src = 'public/js/ckeditor/codebox_widget.js';
                            script.onload = function() {
                                console.log('[Test] CodeBox utility loaded');
                                
                                setTimeout(() => {
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
                                        }, 2000);
                                    }
                                }, 1000);
                            };
                            script.onerror = function() {
                                console.error('[Test] Failed to load CodeBox utility');
                            };
                            document.head.appendChild(script);
                            
                            // Sync content
                            editor.model.document.on('change:data', () => {
                                const data = editor.getData();
                                contentTextarea.value = data;
                                htmlSourceTextarea.value = data;
                            });
                            
                            // Show editor
                            editorContainer.style.display = 'block';
                            
                            // Mode toggle functionality
                            const visualModeBtn = document.getElementById('visualModeBtn');
                            const htmlModeBtn = document.getElementById('htmlModeBtn');
                            
                            visualModeBtn.addEventListener('click', function() {
                                editor.setData(htmlSourceTextarea.value);
                                contentTextarea.value = htmlSourceTextarea.value;
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
                        })
                        .catch(error => {
                            console.error('[Test] CKEditor initialization failed:', error);
                            contentTextarea.style.display = 'block';
                            contentTextarea.style.border = '2px solid #ef4444';
                        });
                } else {
                    console.error('[Test] ClassicEditor is not available');
                }
            }, 100);
        });
        
        function testCodeBox() {
            console.log('[Test] Testing CodeBox insertion...');
            const codeBoxButton = document.querySelector('.ck-codebox-btn');
            if (codeBoxButton) {
                codeBoxButton.click();
                console.log('[Test] CodeBox button clicked');
            } else {
                alert('CodeBox button not found. Check console for details.');
            }
        }
        
        function showDebugInfo() {
            const debugDiv = document.getElementById('debug-info');
            const debugContent = document.getElementById('debug-content');
            
            const info = {
                'ClassicEditor available': typeof ClassicEditor !== 'undefined',
                'CodeBox button exists': !!document.querySelector('.ck-codebox-btn'),
                'CKEditor container visible': document.querySelector('#content-editor').style.display !== 'none',
                'Original textarea hidden': document.querySelector('#content').style.display === 'none',
                'initCodeBox function available': typeof window.initCodeBox === 'function',
                'Current URL': window.location.href,
                'User agent': navigator.userAgent
            };
            
            let html = '<ul class="list-disc pl-6">';
            for (const [key, value] of Object.entries(info)) {
                const status = value ? '✅' : '❌';
                html += `<li>${status} <strong>${key}:</strong> ${value}</li>`;
            }
            html += '</ul>';
            
            debugContent.innerHTML = html;
            debugDiv.style.display = 'block';
        }
    </script>
</body>
</html>