/**
 * CKEditor 5 CodeBox Utility for CDN Setup
 * This is a simplified approach that works with CKEditor CDN builds
 * Instead of a traditional plugin, it extends the existing editor instance
 */

console.log('[CodeBox] Loading CodeBox utility...');

class CodeBoxUtility {
    constructor(editor) {
        this.editor = editor;
        console.log('[CodeBox] CodeBox utility initialized for editor:', editor);
    }

    /**
     * Insert a code box into the editor
     * @param {string} language - Programming language (python, javascript, php, etc.)
     * @param {string} code - The code to insert
     */
    insertCodeBox(language = 'python', code = '') {
        console.log('[CodeBox] Inserting code box with language:', language);
        
        const defaultCode = code || this.getDefaultCode(language);
        const html = this.generateCodeBoxHTML(language, defaultCode);
        
        try {
            // Use the editor's built-in HTML insertion method
            this.editor.model.change(writer => {
                const viewFragment = this.editor.data.processor.toView(html);
                const modelFragment = this.editor.data.toModel(viewFragment);
                this.editor.model.insertContent(modelFragment, this.editor.model.document.selection);
            });
            
            console.log('[CodeBox] Code box inserted successfully');
            return true;
        } catch (error) {
            console.error('[CodeBox] Error inserting code box:', error);
            return false;
        }
    }

    /**
     * Generate HTML for the code box
     * @param {string} language - Programming language
     * @param {string} code - Code content
     * @returns {string} HTML string
     */
    generateCodeBoxHTML(language, code) {
        return `<div class="code-box relative bg-gray-900 text-gray-100 rounded-xl overflow-hidden shadow-lg my-6">
  <div class="flex items-center justify-between bg-gray-800 px-4 py-2 text-sm">
    <div class="flex space-x-1">
      <span class="w-3 h-3 bg-red-500 rounded-full"></span>
      <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
      <span class="w-3 h-3 bg-green-500 rounded-full"></span>
    </div>
    <div class="flex items-center space-x-2">
      <span class="text-gray-400 text-xs">${language}</span>
      <button class="copy-btn text-gray-300 hover:text-white text-xs border border-gray-700 px-2 py-1 rounded-md transition-colors">
        Copy
      </button>
    </div>
  </div>
  <pre class="p-4 overflow-x-auto text-sm"><code class="language-${language}">${this.escapeHtml(code)}</code></pre>
</div>`;
    }

    /**
     * Get default code for a language
     * @param {string} language - Programming language
     * @returns {string} Default code
     */
    getDefaultCode(language) {
        const defaults = {
            python: `# Contoh kode Python
x = 10
y = 3
print(f"Hasil Penjumlahan: {x + y}")`,
            javascript: `// Contoh kode JavaScript
const x = 10;
const y = 3;
console.log(\`Hasil Penjumlahan: \${x + y}\`);`,
            php: `<?php
// Contoh kode PHP
$x = 10;
$y = 3;
echo "Hasil Penjumlahan: " . ($x + $y);`,
            html: `<!-- Contoh kode HTML -->
<div class="container">
  <h1>Hello World</h1>
  <p>Contoh paragraf</p>
</div>`,
            css: `/* Contoh kode CSS */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}`
        };
        
        return defaults[language] || `// Contoh kode ${language}\n// Tulis kode Anda di sini`;
    }

    /**
     * Escape HTML to prevent XSS
     * @param {string} text - Text to escape
     * @returns {string} Escaped text
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
        console.log('[CodeBox] Adding toolbar button...');
        
        try {
            // Create a custom button using the editor's UI
            const editorElement = this.editor.ui.view.element;
            const toolbarElement = editorElement.querySelector('.ck-toolbar');
            
            if (toolbarElement) {
                // Create the CodeBox button
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'ck ck-button ck-off ck-codebox-btn';
                button.title = 'Insert Code Box';
                button.innerHTML = `
                    <span class="ck ck-button__label">
                        <svg viewBox="0 0 20 20" width="20" height="20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Code Box
                    </span>
                `;
                
                // Add click handler
                button.addEventListener('click', () => {
                    this.showLanguageDialog();
                });
                
                // Add button to toolbar
                toolbarElement.appendChild(button);
                
                console.log('[CodeBox] Toolbar button added successfully');
                return true;
            } else {
                console.error('[CodeBox] Toolbar element not found');
                return false;
            }
        } catch (error) {
            console.error('[CodeBox] Error adding toolbar button:', error);
            return false;
        }
    }

    /**
     * Show language selection dialog
     */
    showLanguageDialog() {
        console.log('[CodeBox] Showing language selection dialog...');
        
        const languages = [
            { value: 'python', label: 'Python' },
            { value: 'javascript', label: 'JavaScript' },
            { value: 'php', label: 'PHP' },
            { value: 'html', label: 'HTML' },
            { value: 'css', label: 'CSS' },
            { value: 'sql', label: 'SQL' },
            { value: 'bash', label: 'Bash' }
        ];
        
        // Create a simple modal dialog
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
            <div style="background: white; padding: 20px; border-radius: 8px; max-width: 400px; width: 90%;">
                <h3 style="margin: 0 0 15px 0; color: #333;">Select Programming Language</h3>
                <select id="codebox-language" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">
                    ${languages.map(lang => `<option value="${lang.value}">${lang.label}</option>`).join('')}
                </select>
                <div style="text-align: right;">
                    <button id="codebox-cancel" style="margin-right: 10px; padding: 8px 16px; border: 1px solid #ddd; background: #f5f5f5; border-radius: 4px; cursor: pointer;">Cancel</button>
                    <button id="codebox-insert" style="padding: 8px 16px; background: #2b6cee; color: white; border: none; border-radius: 4px; cursor: pointer;">Insert</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Handle dialog events
        const languageSelect = modal.querySelector('#codebox-language');
        const cancelButton = modal.querySelector('#codebox-cancel');
        const insertButton = modal.querySelector('#codebox-insert');
        
        const closeModal = () => {
            document.body.removeChild(modal);
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
        
        // Focus on select
        languageSelect.focus();
    }
}

/**
 * Initialize CodeBox utility when CKEditor is ready
 * @param {Object} editor - CKEditor instance
 */
window.initCodeBox = function(editor) {
    console.log('[CodeBox] Initializing CodeBox for editor...');
    
    try {
        const codeBox = new CodeBoxUtility(editor);
        
        // Add toolbar button
        if (codeBox.addToolbarButton()) {
            console.log('[CodeBox] CodeBox utility initialized successfully');
            return codeBox;
        } else {
            console.error('[CodeBox] Failed to initialize CodeBox utility');
            return null;
        }
    } catch (error) {
        console.error('[CodeBox] Error initializing CodeBox:', error);
        return null;
    }
};

console.log('[CodeBox] CodeBox utility loaded successfully');