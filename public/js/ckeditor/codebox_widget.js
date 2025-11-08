/**
 * CKEditor 5 CodeBox Widget Implementation
 * Uses a more reliable approach for HTML insertion
 */

console.log('[CodeBox Widget] Loading CodeBox widget utility...');

class CodeBoxWidget {
    constructor(editor) {
        this.editor = editor;
        this.isInitialized = false;
        this.retryCount = 0;
        this.maxRetries = 10;
        console.log('[CodeBox Widget] CodeBox widget created for editor:', editor);
    }

    /**
     * Initialize CodeBox with retry mechanism
     */
    initialize() {
        console.log('[CodeBox Widget] Starting initialization with retry mechanism...');
        
        return new Promise((resolve, reject) => {
            const tryInitialize = () => {
                try {
                    if (this.addToolbarButton()) {
                        this.isInitialized = true;
                        console.log('[CodeBox Widget] CodeBox widget initialized successfully');
                        resolve(this);
                    } else {
                        this.retryCount++;
                        if (this.retryCount < this.maxRetries) {
                            console.log(`[CodeBox Widget] Retry ${this.retryCount}/${this.maxRetries} in 500ms...`);
                            setTimeout(tryInitialize, 500);
                        } else {
                            console.error('[CodeBox Widget] Failed to initialize after maximum retries');
                            reject(new Error('Failed to initialize CodeBox after maximum retries'));
                        }
                    }
                } catch (error) {
                    console.error('[CodeBox Widget] Error during initialization:', error);
                    reject(error);
                }
            };
            
            tryInitialize();
        });
    }

    /**
     * Insert a code box using the most reliable method
     */
    insertCodeBox(language = 'python', code = '') {
        console.log('[CodeBox Widget] Inserting code box with language:', language);
        
        if (!this.isInitialized) {
            console.warn('[CodeBox Widget] CodeBox not initialized, attempting to initialize...');
            this.initialize().then(() => {
                this.insertCodeBox(language, code);
            }).catch(error => {
                console.error('[CodeBox Widget] Failed to initialize for insertion:', error);
            });
            return false;
        }
        
        const defaultCode = code || this.getDefaultCode(language);
        const html = this.generateCodeBoxHTML(language, defaultCode);
        
        // Use the simplest and most reliable method: append to current content
        try {
            const currentData = this.editor.getData();
            
            // Try to insert at cursor position using the view API
            const selection = this.editor.model.document.selection;
            if (selection && selection.focus) {
                try {
                    // Use the view writer to insert HTML at cursor position
                    this.editor.model.change(writer => {
                        const viewFragment = this.editor.data.processor.toView(html);
                        const modelFragment = this.editor.data.toModel(viewFragment);
                        writer.insert(modelFragment, selection.focus);
                    });
                    console.log('[CodeBox Widget] Code box inserted at cursor position');
                    return true;
                } catch (cursorError) {
                    console.warn('[CodeBox Widget] Cursor insertion failed, using append method:', cursorError);
                }
            }
            
            // Fallback: append at the end with proper spacing
            let newData = currentData;
            if (!newData.endsWith('\n')) {
                newData += '\n';
            }
            newData += '\n' + html + '\n\n';
            this.editor.setData(newData);
            
            console.log('[CodeBox Widget] Code box inserted successfully');
            return true;
            
        } catch (error) {
            console.error('[CodeBox Widget] Error inserting code box:', error);
            
            // Ultimate fallback: simple append
            try {
                const currentData = this.editor.getData();
                this.editor.setData(currentData + '\n\n' + html);
                console.log('[CodeBox Widget] Code box inserted using ultimate fallback method');
                return true;
            } catch (fallbackError) {
                console.error('[CodeBox Widget] All methods failed:', fallbackError);
                return false;
            }
        }
    }

    /**
     * Generate HTML for the code box
     */
    generateCodeBoxHTML(language, code) {
        return '<div class="code-box">\n  <div class="code-box-header">\n    <div class="code-box-controls">\n      <span class="code-box-dot red"></span>\n      <span class="code-box-dot yellow"></span>\n      <span class="code-box-dot green"></span>\n    </div>\n    <div class="code-box-info">\n      <span class="code-box-language">' + language + '</span>\n      <button class="copy-btn">Copy</button>\n    </div>\n  </div>\n  <pre><code class="language-' + language + '">' + this.escapeHtml(code) + '</code></pre>\n</div>';
    }

    /**
     * Get default code for a language
     */
    getDefaultCode(language) {
        var defaults = {
            python: '# Contoh kode Python\nx = 10\ny = 3\nprint("Hasil Penjumlahan: " + str(x + y))',
            javascript: '// Contoh kode JavaScript\nconst x = 10;\nconst y = 3;\nconsole.log("Hasil Penjumlahan: " + (x + y));',
            php: '<?php\n// Contoh kode PHP\n$x = 10;\n$y = 3;\necho "Hasil Penjumlahan: " . ($x + $y);',
            html: '<!-- Contoh kode HTML -->\n<div class="container">\n  <h1>Hello World</h1>\n  <p>Contoh paragraf</p>\n</div>',
            css: '/* Contoh kode CSS */\n.container {\n  max-width: 1200px;\n  margin: 0 auto;\n  padding: 20px;\n}'
        };
        
        return defaults[language] || '// Contoh kode ' + language + '\n// Tulis kode Anda di sini';
    }

    /**
     * Escape HTML to prevent XSS
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Add CodeBox button to the editor toolbar
     */
    addToolbarButton() {
        console.log('[CodeBox Widget] Adding toolbar button...');
        
        try {
            const editorElement = this.editor.ui.view.element;
            if (!editorElement) {
                console.error('[CodeBox Widget] Editor element not found');
                return false;
            }
            
            // Try multiple toolbar selectors
            const toolbarSelectors = [
                '.ck-toolbar',
                '.ck-toolbar__items',
                '.ck-toolbar__wrapper',
                '[class*="ck-toolbar"]'
            ];
            
            let toolbarElement = null;
            let selectorUsed = '';
            
            for (const selector of toolbarSelectors) {
                toolbarElement = editorElement.querySelector(selector);
                if (toolbarElement) {
                    selectorUsed = selector;
                    console.log(`[CodeBox Widget] Toolbar found using selector: ${selector}`);
                    break;
                }
            }
            
            if (!toolbarElement) {
                console.error('[CodeBox Widget] Toolbar element not found with any selector');
                return false;
            }
            
            // Check if button already exists
            const existingButton = toolbarElement.querySelector('.ck-codebox-btn');
            if (existingButton) {
                console.log('[CodeBox Widget] CodeBox button already exists');
                return true;
            }
            
            // Create the CodeBox button
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'ck ck-button ck-off ck-codebox-btn';
            button.title = 'Insert Code Box';
            button.setAttribute('tabindex', '-1');
            button.innerHTML = '<span class="ck ck-button__label"><svg viewBox="0 0 20 20" width="20" height="20" style="margin-right: 4px;"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>Code Box</span>';
            
            // Add click handler
            button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.showLanguageDialog();
            });
            
            // Find the best place to insert the button
            let insertLocation = toolbarElement;
            
            // Try to find the toolbar items container
            const toolbarItems = toolbarElement.querySelector('.ck-toolbar__items');
            if (toolbarItems) {
                insertLocation = toolbarItems;
                console.log('[CodeBox Widget] Using toolbar items container');
            }
            
            // Insert button at the end
            insertLocation.appendChild(button);
            
            // Add custom CSS for the button
            this.addToolbarButtonStyles();
            
            console.log('[CodeBox Widget] Toolbar button added successfully');
            return true;
            
        } catch (error) {
            console.error('[CodeBox Widget] Error adding toolbar button:', error);
            return false;
        }
    }

    /**
     * Add custom CSS for the toolbar button
     */
    addToolbarButtonStyles() {
        const styleId = 'codebox-toolbar-styles';
        if (!document.getElementById(styleId)) {
            const style = document.createElement('style');
            style.id = styleId;
            style.textContent = `
                .ck-codebox-btn {
                    margin-left: 2px !important;
                    margin-right: 2px !important;
                }
                .ck-codebox-btn:hover {
                    background-color: #f0f0f0 !important;
                }
                .ck-codebox-btn .ck-button__label {
                    display: flex;
                    align-items: center;
                    font-size: 12px;
                }
                .ck.ck-toolbar .ck-codebox-btn {
                    border: 1px solid #c4c4c4;
                    border-radius: 2px;
                    padding: 4px 6px;
                }
                .ck.ck-toolbar .ck-codebox-btn:hover {
                    background: #f0f0f0;
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Show language selection dialog
     */
    showLanguageDialog() {
        console.log('[CodeBox Widget] Showing language selection dialog...');
        
        const languages = [
            { value: 'python', label: 'Python' },
            { value: 'javascript', label: 'JavaScript' },
            { value: 'php', label: 'PHP' },
            { value: 'html', label: 'HTML' },
            { value: 'css', label: 'CSS' },
            { value: 'sql', label: 'SQL' },
            { value: 'bash', label: 'Bash' }
        ];
        
        // Create modal dialog
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        `;
        
        modal.innerHTML = `
            <div style="background: white; padding: 20px; border-radius: 8px; max-width: 400px; width: 90%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px 0; color: #333; font-size: 16px;">Select Programming Language</h3>
                <select id="codebox-language" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    '` + languages.map(function(lang) { return '<option value="' + lang.value + '">' + lang.label + '</option>'; }).join('') + `'
                </select>
                <div style="text-align: right;">
                    <button id="codebox-cancel" style="margin-right: 10px; padding: 8px 16px; border: 1px solid #ddd; background: #f5f5f5; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancel</button>
                    <button id="codebox-insert" style="padding: 8px 16px; background: #2b6cee; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Insert</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Handle dialog events
        const languageSelect = modal.querySelector('#codebox-language');
        const cancelButton = modal.querySelector('#codebox-cancel');
        const insertButton = modal.querySelector('#codebox-insert');
        
        const closeModal = () => {
            if (document.body.contains(modal)) {
                document.body.removeChild(modal);
            }
        };
        
        cancelButton.addEventListener('click', closeModal);
        
        insertButton.addEventListener('click', () => {
            const selectedLanguage = languageSelect.value;
            this.insertCodeBox(selectedLanguage);
            closeModal();
        });
        
        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        // Close on Escape key
        const escapeHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escapeHandler);
            }
        };
        document.addEventListener('keydown', escapeHandler);
        
        // Focus on select
        setTimeout(() => languageSelect.focus(), 100);
    }
}

/**
 * Initialize CodeBox widget when CKEditor is ready
 */
window.initCodeBox = function(editor) {
    console.log('[CodeBox Widget] Initializing CodeBox widget for editor...');
    
    try {
        const codeBox = new CodeBoxWidget(editor);
        
        // Initialize with retry mechanism
        codeBox.initialize()
            .then((initializedCodeBox) => {
                console.log('[CodeBox Widget] CodeBox widget initialized successfully');
                return initializedCodeBox;
            })
            .catch((error) => {
                console.error('[CodeBox Widget] Failed to initialize CodeBox widget:', error);
                return null;
            });
        
        return codeBox;
    } catch (error) {
        console.error('[CodeBox Widget] Error initializing CodeBox:', error);
        return null;
    }
};

console.log('[CodeBox Widget] CodeBox widget utility loaded successfully');