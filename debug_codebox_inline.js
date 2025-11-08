/**
 * Inline CodeBox Debug Script
 * Add this script to the article edit page to debug CodeBox issues
 */

console.log('[CodeBox Debug] Starting comprehensive debug...');

// Enhanced debug logging
function debugLog(message, type = 'info') {
    const timestamp = new Date().toLocaleTimeString();
    const prefix = `[${timestamp}] [CodeBox Debug]`;
    
    switch(type) {
        case 'error':
            console.error(prefix, message);
            break;
        case 'warn':
            console.warn(prefix, message);
            break;
        case 'success':
            console.log(`%c${prefix} ${message}`, 'color: green; font-weight: bold;');
            break;
        default:
            console.log(prefix, message);
    }
}

// Wait for DOM and CKEditor
document.addEventListener('DOMContentLoaded', function() {
    debugLog('DOM loaded, waiting for CKEditor...');
    
    // Monitor CKEditor initialization
    let ckEditorCheckCount = 0;
    const ckEditorInterval = setInterval(() => {
        ckEditorCheckCount++;
        
        if (typeof ClassicEditor !== 'undefined') {
            debugLog('ClassicEditor is available', 'success');
            clearInterval(ckEditorInterval);
            
            // Monitor for editor creation
            setTimeout(() => {
                const editorElements = document.querySelectorAll('.ck-editor__editable');
                debugLog(`Found ${editorElements.length} CKEditor editable elements`);
                
                if (editorElements.length > 0) {
                    debugLog('CKEditor appears to be initialized');
                    
                    // Look for toolbar
                    const toolbars = document.querySelectorAll('.ck-toolbar');
                    debugLog(`Found ${toolbars.length} toolbars`);
                    
                    toolbars.forEach((toolbar, index) => {
                        debugLog(`Toolbar ${index}: ${toolbar.className}`);
                        debugLog(`Toolbar ${index} children: ${toolbar.children.length}`);
                    });
                    
                    // Check for CodeBox button
                    setTimeout(() => {
                        const codeBoxButtons = document.querySelectorAll('.ck-codebox-btn');
                        debugLog(`Found ${codeBoxButtons.length} CodeBox buttons`, codeBoxButtons.length > 0 ? 'success' : 'error');
                        
                        if (codeBoxButtons.length === 0) {
                            debugLog('CodeBox button NOT found - investigating...', 'warn');
                            
                            // Check if CodeBox script loaded
                            if (typeof window.initCodeBox === 'function') {
                                debugLog('initCodeBox function exists', 'success');
                                
                                // Try to find any CKEditor instance
                                const editors = document.querySelectorAll('.ck-editor__editable');
                                editors.forEach((editor, index) => {
                                    debugLog(`Editor ${index} found: ${editor.tagName}.${editor.className}`);
                                });
                                
                            } else {
                                debugLog('initCodeBox function NOT found', 'error');
                                
                                // Check if script tag exists
                                const codeBoxScript = document.querySelector('script[src*="codebox.js"]');
                                if (codeBoxScript) {
                                    debugLog('CodeBox script tag found but function not available', 'error');
                                    debugLog(`Script src: ${codeBoxScript.src}`);
                                    debugLog(`Script loaded: ${codeBoxScript.readyState || 'unknown'}`);
                                } else {
                                    debugLog('CodeBox script tag NOT found', 'error');
                                }
                            }
                        }
                    }, 2000); // Wait 2 seconds for CodeBox to initialize
                    
                } else {
                    debugLog('CKEditor editable elements NOT found', 'error');
                }
            }, 1000);
            
        } else {
            debugLog(`ClassicEditor not available (check ${ckEditorCheckCount})`, 'warn');
            
            if (ckEditorCheckCount > 10) {
                debugLog('Giving up on ClassicEditor check', 'error');
                clearInterval(ckEditorInterval);
            }
        }
    }, 500);
    
    // Monitor script loading
    const scriptObserver = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'SCRIPT') {
                    if (node.src && node.src.includes('codebox.js')) {
                        debugLog('CodeBox script added to DOM', 'info');
                        
                        node.addEventListener('load', () => {
                            debugLog('CodeBox script loaded successfully', 'success');
                            
                            setTimeout(() => {
                                if (typeof window.initCodeBox === 'function') {
                                    debugLog('initCodeBox function is now available', 'success');
                                } else {
                                    debugLog('initCodeBox function still not available after load', 'error');
                                }
                            }, 100);
                        });
                        
                        node.addEventListener('error', () => {
                            debugLog('CodeBox script failed to load', 'error');
                        });
                    }
                }
            });
        });
    });
    
    scriptObserver.observe(document.head, {
        childList: true,
        subtree: true
    });
    
    // Add manual debug button
    setTimeout(() => {
        const debugButton = document.createElement('button');
        debugButton.textContent = 'Debug CodeBox';
        debugButton.style.cssText = `
            position: fixed;
            top: 10px;
            left: 10px;
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 10000;
        `;
        
        debugButton.addEventListener('click', () => {
            console.clear();
            debugLog('=== Manual CodeBox Debug Started ===', 'info');
            
            // Check all relevant elements
            debugLog(`ClassicEditor available: ${typeof ClassicEditor !== 'undefined'}`);
            debugLog(`initCodeBox available: ${typeof window.initCodeBox === 'function'}`);
            
            const toolbars = document.querySelectorAll('.ck-toolbar');
            debugLog(`Toolbars found: ${toolbars.length}`);
            
            const codeBoxButtons = document.querySelectorAll('.ck-codebox-btn');
            debugLog(`CodeBox buttons found: ${codeBoxButtons.length}`);
            
            const editors = document.querySelectorAll('.ck-editor__editable');
            debugLog(`Editors found: ${editors.length}`);
            
            // Try to manually initialize CodeBox if possible
            if (typeof ClassicEditor !== 'undefined' && typeof window.initCodeBox === 'function') {
                debugLog('Attempting manual CodeBox initialization...', 'info');
                
                // Look for any CKEditor instance in window
                const editorInstances = Object.keys(window).filter(key => 
                    key.includes('editor') || key.includes('Editor')
                );
                debugLog(`Potential editor instances: ${editorInstances.join(', ')}`);
                
            }
            
            debugLog('=== Manual Debug Complete ===', 'info');
        });
        
        document.body.appendChild(debugButton);
        debugLog('Debug button added to page', 'success');
    }, 2000);
});

debugLog('CodeBox debug script loaded', 'success');