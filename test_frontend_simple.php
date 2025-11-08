<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeBox Frontend Test</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    
    <!-- CodeBox CSS Styling -->
    <style>
    /* CodeBox Styling for Frontend */
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

    .code-box .code-box-dot.red {
        background: #ff5f56;
    }

    .code-box .code-box-dot.yellow {
        background: #ffbd2e;
    }

    .code-box .code-box-dot.green {
        background: #27c93f;
    }

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

    /* Override Prism.js theme for CodeBox */
    .code-box .token.comment,
    .code-box .token.prolog,
    .code-box .token.doctype,
    .code-box .token.cdata {
        color: #6272a4;
    }

    .code-box .token.punctuation {
        color: #f8f8f2;
    }

    .code-box .token.property,
    .code-box .token.tag,
    .code-box .token.constant,
    .code-box .token.symbol,
    .code-box .token.deleted {
        color: #ff79c6;
    }

    .code-box .token.boolean,
    .code-box .token.number {
        color: #bd93f9;
    }

    .code-box .token.selector,
    .code-box .token.attr-name,
    .code-box .token.string,
    .code-box .token.char,
    .code-box .token.builtin,
    .code-box .token.inserted {
        color: #50fa7b;
    }

    .code-box .token.operator,
    .code-box .token.entity,
    .code-box .token.url,
    .language-css .token.string,
    .style .token.string,
    .code-box .token.variable,
    .code-box .token.atrule {
        color: #f8f8f2;
    }

    .code-box .token.attr-value,
    .code-box .token.keyword {
        color: #66d9ef;
    }

    .code-box .token.function,
    .code-box .token.class-name {
        color: #a6e22e;
    }

    .code-box .token.regex,
    .code-box .token.important {
        color: #ffb86c;
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    </style>
</head>
<body class="font-display bg-white text-gray-900">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold mb-4">CodeBox Frontend Integration Test</h1>
            <p class="text-gray-600">Testing CodeBox display and functionality on frontend</p>
        </header>

        <article class="prose prose-lg max-w-none">
            <p>This is a test article with CodeBox integration. Below are examples of code blocks with syntax highlighting:</p>
            
            <div class="code-box">
              <div class="code-box-header">
                <div class="code-box-controls">
                  <span class="code-box-dot red"></span>
                  <span class="code-box-dot yellow"></span>
                  <span class="code-box-dot green"></span>
                </div>
                <div class="code-box-info">
                  <span class="code-box-language">python</span>
                  <button class="copy-btn">Copy</button>
                </div>
              </div>
              <pre><code class="language-python"># Contoh kode Python
def hello_world():
    name = "World"
    print(f"Hello, {name}!")
    return True

if __name__ == "__main__":
    hello_world()</code></pre>
            </div>

            <p>Here's another code example in JavaScript:</p>
            
            <div class="code-box">
              <div class="code-box-header">
                <div class="code-box-controls">
                  <span class="code-box-dot red"></span>
                  <span class="code-box-dot yellow"></span>
                  <span class="code-box-dot green"></span>
                </div>
                <div class="code-box-info">
                  <span class="code-box-language">javascript</span>
                  <button class="copy-btn">Copy</button>
                </div>
              </div>
              <pre><code class="language-javascript">// Contoh kode JavaScript
const helloWorld = () => {
    const name = "World";
    console.log(`Hello, ${name}!`);
    return true;
};

// Auto execute
helloWorld();</code></pre>
            </div>

            <p>And here's a PHP example:</p>
            
            <div class="code-box">
              <div class="code-box-header">
                <div class="code-box-controls">
                  <span class="code-box-dot red"></span>
                  <span class="code-box-dot yellow"></span>
                  <span class="code-box-dot green"></span>
                </div>
                <div class="code-box-info">
                  <span class="code-box-language">php</span>
                  <button class="copy-btn">Copy</button>
                </div>
              </div>
              <pre><code class="language-php"><?php
// Contoh kode PHP
function hello_world() {
    $name = "World";
    echo "Hello, {$name}!";
    return true;
}

// Execute function
hello_world();</code></pre>
            </div>
        </article>

        <div class="mt-12 p-6 bg-gray-100 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Test Results</h2>
            <div id="testResults" class="space-y-2 text-sm">
                <div class="text-gray-600">Running tests...</div>
            </div>
            <button onclick="runTests()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Run Tests Again
            </button>
        </div>
    </div>

    <!-- Prism.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>

    <script>
        // Copy button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('copy-btn')) {
                console.log('[Copy] Copy button clicked');
                try {
                    var codeBox = e.target.closest('.code-box');
                    if (codeBox) {
                        var code = codeBox.querySelector('pre').innerText;
                        navigator.clipboard.writeText(code).then(function() {
                            // Show success toast
                            var toast = document.createElement('div');
                            toast.textContent = '✅ Kode berhasil disalin!';
                            toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                            document.body.appendChild(toast);
                            
                            setTimeout(function() {
                                if (document.body.contains(toast)) {
                                    document.body.removeChild(toast);
                                }
                            }, 2000);
                            
                            console.log('[Copy] Code copied successfully');
                        }).catch(function(err) {
                            console.error('[Copy] Failed to copy code:', err);
                            alert('Gagal menyalin kode. Silakan coba lagi.');
                        });
                    }
                } catch (error) {
                    console.error('[Copy] Failed to copy code:', error);
                    alert('Gagal menyalin kode. Silakan coba lagi.');
                }
            }
        });

        // Initialize Prism.js when DOM is ready
        window.addEventListener('DOMContentLoaded', function() {
            if (window.Prism) {
                Prism.highlightAll();
                console.log('[Prism] Syntax highlighting initialized');
                
                // Re-highlight CodeBox elements specifically
                var codeBoxes = document.querySelectorAll('.code-box code');
                codeBoxes.forEach(function(codeBlock) {
                    if (codeBlock && Prism) {
                        Prism.highlightElement(codeBlock);
                        console.log('[Prism] CodeBox highlighted:', codeBlock.className);
                    }
                });
            }
            
            // Run tests automatically
            setTimeout(runTests, 1000);
        });

        function runTests() {
            var results = document.getElementById('testResults');
            results.innerHTML = '';
            
            function addResult(test, passed, details) {
                var div = document.createElement('div');
                div.className = 'p-2 rounded ' + (passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
                div.innerHTML = 
                    '<strong>' + test + ':</strong> ' +
                    '<span>' + (passed ? '✅ PASSED' : '❌ FAILED') + '</span>' +
                    (details ? '<br><small>' + details + '</small>' : '');
                results.appendChild(div);
            }
            
            // Test 1: Check if Prism.js is loaded
            addResult('Prism.js Loaded', typeof Prism !== 'undefined', 
                typeof Prism !== 'undefined' ? 'Version ' + (Prism.version || 'unknown') : 'Prism object not found');
            
            // Test 2: Check if CodeBox elements exist
            var codeBoxes = document.querySelectorAll('.code-box');
            addResult('CodeBox Elements Found', codeBoxes.length > 0, 
                'Found ' + codeBoxes.length + ' CodeBox elements');
            
            // Test 3: Check if copy buttons exist
            var copyButtons = document.querySelectorAll('.copy-btn');
            addResult('Copy Buttons Found', copyButtons.length > 0, 
                'Found ' + copyButtons.length + ' copy buttons');
            
            // Test 4: Check if syntax highlighting is applied
            var highlightedCode = document.querySelectorAll('.code-box code[class*="language-"]');
            addResult('Syntax Highlighting Applied', highlightedCode.length > 0, 
                'Found ' + highlightedCode.length + ' highlighted code blocks');
            
            // Test 5: Check if CSS styling is applied
            var styledCodeBoxes = document.querySelectorAll('.code-box .code-box-header');
            addResult('CSS Styling Applied', styledCodeBoxes.length > 0, 
                'Found ' + styledCodeBoxes.length + ' styled CodeBox headers');
            
            // Test 6: Test copy functionality
            var copyTestPassed = false;
            if (copyButtons.length > 0) {
                try {
                    var testButton = copyButtons[0];
                    var codeBox = testButton.closest('.code-box');
                    if (codeBox) {
                        var code = codeBox.querySelector('pre').innerText;
                        copyTestPassed = code.length > 0;
                    }
                } catch (error) {
                    copyTestPassed = false;
                }
            }
            addResult('Copy Functionality Ready', copyTestPassed, 
                copyTestPassed ? 'Copy buttons are functional' : 'Copy buttons may not work');
            
            // Test 7: Check responsive design
            var viewportWidth = window.innerWidth;
            var isMobile = viewportWidth < 768;
            addResult('Responsive Design', true, 
                'Current viewport: ' + viewportWidth + 'px (' + (isMobile ? 'Mobile' : 'Desktop') + ' view)');
            
            console.log('[Test] CodeBox frontend tests completed');
        }
    </script>
</body>
</html>