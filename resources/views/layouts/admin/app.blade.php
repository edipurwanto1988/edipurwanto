<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- TinyMCE with Code Sample Plugin (Self-hosted open-source version) -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// TinyMCE configuration with Code Sample plugin
window.TinyMCEConfig = {
    selector: 'textarea.tinymce-editor',
    height: 400,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
    ],
    toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help | codesample',
    codesample_languages: [
        {text: 'HTML/XML', value: 'markup'},
        {text: 'JavaScript', value: 'javascript'},
        {text: 'CSS', value: 'css'},
        {text: 'PHP', value: 'php'},
        {text: 'Python', value: 'python'},
        {text: 'Java', value: 'java'},
        {text: 'C', value: 'c'},
        {text: 'C++', value: 'cpp'},
        {text: 'C#', value: 'csharp'},
        {text: 'SQL', value: 'sql'},
        {text: 'Bash', value: 'bash'},
        {text: 'JSON', value: 'json'},
        {text: 'YAML', value: 'yaml'},
        {text: 'Markdown', value: 'markdown'}
    ],
    content_style: `
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .mce-content-body {
            margin: 1rem;
        }
        /* Code sample styling */
        pre {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 1rem;
            overflow-x: auto;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            line-height: 1.4;
        }
        code {
            background: #f5f5f5;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
        }
    `,
    setup: function(editor) {
        console.log('[TinyMCE] Editor initialized:', editor.id);
        
        // Add custom CSS for better code sample integration
        editor.on('init', function() {
            console.log('[TinyMCE] Editor ready');
            
            // Add Prism.js compatibility classes
            const contentDoc = editor.getDoc();
            const style = contentDoc.createElement('style');
            style.textContent = `
                /* Prism.js compatibility for TinyMCE code samples */
                .mce-content-body pre[class*="language-"] {
                    background: #2d2d2d;
                    color: #f8f8f2;
                    border-radius: 8px;
                    padding: 1rem;
                    margin: 1rem 0;
                    overflow-x: auto;
                }
                .mce-content-body code[class*="language-"] {
                    background: transparent;
                    color: inherit;
                    padding: 0;
                    border-radius: 0;
                }
            `;
            contentDoc.head.appendChild(style);
        });
        
        // Handle content changes
        editor.on('change', function() {
            const content = editor.getContent();
            const textarea = document.getElementById(editor.id.replace('-tinymce', ''));
            if (textarea) {
                textarea.value = content;
            }
        });
        
        // Sync content on form submission
        const form = editor.targetElm ? editor.targetElm.form : null;
        if (form) {
            form.addEventListener('submit', function() {
                editor.save();
                console.log('[TinyMCE] Content synced on form submission');
            });
        } else {
            // Fallback: find the form containing the original textarea
            const textareaId = editor.id.replace('-tinymce', '');
            const textarea = document.getElementById(textareaId);
            if (textarea && textarea.form) {
                textarea.form.addEventListener('submit', function() {
                    editor.save();
                    console.log('[TinyMCE] Content synced on form submission (fallback)');
                });
            }
        }
    }
};

// Initialize TinyMCE when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('[TinyMCE] DOM ready, initializing editors...');
    
    // Find all textareas that should be TinyMCE editors (only content, not excerpt)
    const textareas = document.querySelectorAll('textarea#content');
    textareas.forEach(function(textarea) {
        textarea.classList.add('tinymce-editor');
    });
    
    // Initialize TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymce.init(window.TinyMCEConfig);
        console.log('[TinyMCE] Initialization started');
    } else {
        console.error('[TinyMCE] TinyMCE not loaded');
    }
    
    // Initialize Prism.js
    if (window.Prism) {
        Prism.highlightAll();
        console.log('[Prism] Syntax highlighting initialized');
        
        // Highlight existing code blocks
        const codeBlocks = document.querySelectorAll('pre code[class*="language-"]');
        codeBlocks.forEach((block) => {
            Prism.highlightElement(block);
        });
    }
});
</script>
<!-- Prism.js for syntax highlighting -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b6cee",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
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
@stack('styles')
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex min-h-screen w-full">
<!-- Mobile Menu Button -->
<div class="md:hidden fixed top-4 left-4 z-50">
    <button id="admin-mobile-menu-button" class="text-gray-600 dark:text-gray-400 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:bg-gray-50 dark:hover:bg-gray-700">
        <span class="material-symbols-outlined text-xl">menu</span>
    </button>
</div>

<!-- SideNavBar -->
<aside id="admin-sidebar" class="sticky top-0 h-screen flex flex-col w-64 bg-white dark:bg-background-dark dark:border-r dark:border-gray-800 shadow-sm transform md:transform-none transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0">
<div class="flex h-full flex-col justify-between p-4">
<div class="flex flex-col gap-8">
<div class="flex items-center gap-3 px-3">
<div class="bg-primary rounded-lg p-2 text-white flex items-center justify-center">
<span class="material-symbols-outlined" style="font-size: 24px;">quiz</span>
</div>
<h1 class="text-gray-900 dark:text-white text-lg font-bold">Admin</h1>
</div>
<nav class="flex flex-col gap-2">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary dark:bg-primary/20" href="{{ route('adminku.dashboard') }}">
<span class="material-symbols-outlined" style="font-size: 24px;">dashboard</span>
<p class="text-sm font-medium">Dashboard</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="{{ route('adminku.articles.index') }}">
<span class="material-symbols-outlined" style="font-size: 24px;">description</span>
<p class="text-sm font-medium">Articles</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="{{ route('adminku.categories.index') }}">
<span class="material-symbols-outlined" style="font-size: 24px;">category</span>
<p class="text-sm font-medium">Categories</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="{{ route('adminku.pages.index') }}">
<span class="material-symbols-outlined" style="font-size: 24px;">article</span>
<p class="text-sm font-medium">Pages</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="{{ route('adminku.menus.index') }}">
<span class="material-symbols-outlined" style="font-size: 24px;">menu</span>
<p class="text-sm font-medium">Menus</p>
</a>
</nav>
</div>
<div class="flex flex-col gap-2 border-t border-gray-200 dark:border-gray-800 pt-4">
<div class="flex items-center gap-3 px-3 py-2">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="User avatar image" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBrkSo5RSu_rPT2EWWm58czG49WZtt0oPOQVd1GtmNA4n0VWA_uWAwdDly3FaY2fpwKftbl7GnJVa_L5kv5w0-E6FABnkOdvEvH-qIFTmE60Ws6Z7lfvTxPPwjhNJe__e_W-wK28YSzSQtoX15JYLRXVtOaS7iGvwHUoluDkLJpM-LgbXM4l5n_usqTX5uHPaYtN75jguiKw_-TACPmClX8n1WcqdOBavKbVMqR42xuICZBJlgm0l-ibJ9pRAg3axiOmWFhRzFpEYk");'></div>
<div class="flex flex-col">
<h2 class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ Auth::user()->name ?? 'Admin User' }}</h2>
<p class="text-gray-500 dark:text-gray-400 text-xs">Blog Admin</p>
</div>
<form method="POST" action="{{ route('logout') }}" class="ml-auto">
@csrf
<button type="submit" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
<span class="material-symbols-outlined" style="font-size: 24px;">logout</span>
</button>
</form>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 p-6 lg:p-10 md:ml-0">
<div class="mx-auto max-w-7xl">
@yield('content')
</div>
</main>
</div>
@stack('scripts')
<!-- TinyMCE Code Sample Styling for Admin -->
<style>
/* TinyMCE Code Sample Styling for Admin */
.mce-content-body pre[class*="language-"] {
    background: #2d2d2d !important;
    color: #f8f8f2 !important;
    border-radius: 8px !important;
    padding: 1rem !important;
    margin: 1rem 0 !important;
    overflow-x: auto !important;
    border: 1px solid #444 !important;
    font-family: 'Fira Code', 'Monaco', 'Consolas', 'Ubuntu Mono', monospace !important;
    font-size: 14px !important;
    line-height: 1.5 !important;
}

.mce-content-body code[class*="language-"] {
    background: transparent !important;
    color: inherit !important;
    padding: 0 !important;
    border-radius: 0 !important;
    font-family: inherit !important;
    font-size: inherit !important;
}

.mce-content-body pre {
    background: #f5f5f5 !important;
    border: 1px solid #ddd !important;
    border-radius: 4px !important;
    padding: 1rem !important;
    overflow-x: auto !important;
    font-family: 'Courier New', Courier, monospace !important;
    font-size: 13px !important;
    line-height: 1.4 !important;
    margin: 1rem 0 !important;
}

.mce-content-body code {
    background: #f5f5f5 !important;
    padding: 0.2rem 0.4rem !important;
    border-radius: 3px !important;
    font-family: 'Courier New', Courier, monospace !important;
    font-size: 13px !important;
}

/* Prism.js theme override for TinyMCE */
.mce-content-body .token.comment,
.mce-content-body .token.prolog,
.mce-content-body .token.doctype,
.mce-content-body .token.cdata {
    color: #6272a4 !important;
}

.mce-content-body .token.punctuation {
    color: #f8f8f2 !important;
}

.mce-content-body .token.property,
.mce-content-body .token.tag,
.mce-content-body .token.constant,
.mce-content-body .token.symbol,
.mce-content-body .token.deleted {
    color: #ff79c6 !important;
}

.mce-content-body .token.boolean,
.mce-content-body .token.number {
    color: #bd93f9 !important;
}

.mce-content-body .token.selector,
.mce-content-body .token.attr-name,
.mce-content-body .token.string,
.mce-content-body .token.char,
.mce-content-body .token.builtin,
.mce-content-body .token.inserted {
    color: #50fa7b !important;
}

.mce-content-body .token.operator,
.mce-content-body .token.entity,
.mce-content-body .token.url,
.mce-content-body .language-css .token.string,
.mce-content-body .style .token.string,
.mce-content-body .token.variable,
.mce-content-body .token.atrule {
    color: #f8f8f2 !important;
}

.mce-content-body .token.attr-value,
.mce-content-body .token.keyword {
    color: #66d9ef !important;
}

.mce-content-body .token.function,
.mce-content-body .token.class-name {
    color: #a6e22e !important;
}

.mce-content-body .token.regex,
.mce-content-body .token.important {
    color: #ffb86c !important;
}

/* Dark mode support */
.dark .mce-content-body pre[class*="language-"] {
    background: #1a1a1a !important;
    border-color: #333 !important;
}

.dark .mce-content-body pre {
    background: #2d2d2d !important;
    border-color: #444 !important;
    color: #f8f8f2 !important;
}

.dark .mce-content-body code {
    background: #2d2d2d !important;
    color: #f8f8f2 !important;
}
</style>

<!-- Prism.js for syntax highlighting (compatible with TinyMCE) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-yaml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markdown.min.js"></script>

<!-- Enhanced copy functionality for TinyMCE code samples -->
<script>
document.addEventListener('click', async (e) => {
    // Handle TinyMCE code sample copy buttons
    if (e.target.classList.contains('mce-copy') || e.target.closest('.mce-copy')) {
        console.log('[TinyMCE Copy] Copy button clicked');
        try {
            const codeBlock = e.target.closest('pre') || e.target.closest('.mce-content-body pre');
            if (codeBlock) {
                const code = codeBlock.textContent || codeBlock.innerText;
                await navigator.clipboard.writeText(code);
                
                // Show success toast
                showToast('✅ Kode berhasil disalin!');
                console.log('[TinyMCE Copy] Code copied successfully');
            }
        } catch (error) {
            console.error('[TinyMCE Copy] Failed to copy code:', error);
            showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
        }
    }
    
    // Handle legacy CodeBox copy buttons (for backward compatibility)
    if (e.target.classList.contains('copy-btn')) {
        console.log('[Legacy Copy] Copy button clicked');
        try {
            const codeBox = e.target.closest('.code-box');
            if (codeBox) {
                const code = codeBox.querySelector('pre').innerText;
                await navigator.clipboard.writeText(code);
                showToast('✅ Kode berhasil disalin!');
                console.log('[Legacy Copy] Code copied successfully');
            }
        } catch (error) {
            console.error('[Legacy Copy] Failed to copy code:', error);
            showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
        }
    }
});

// Toast notification helper
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (document.body.contains(toast)) {
            document.body.removeChild(toast);
        }
    }, 2000);
}


// Enhanced MutationObserver for TinyMCE content changes
const prismObserver = new MutationObserver((mutations) => {
    if (window.Prism) {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    // Handle TinyMCE content
                    const tinymceCodeBlocks = node.querySelectorAll && node.querySelectorAll('pre code[class*="language-"]');
                    if (tinymceCodeBlocks && tinymceCodeBlocks.length > 0) {
                        tinymceCodeBlocks.forEach((codeBlock) => {
                            Prism.highlightElement(codeBlock);
                        });
                        console.log('[Prism] TinyMCE code blocks highlighted');
                    }
                    
                    // Handle legacy CodeBox elements
                    const legacyCodeBoxes = node.querySelectorAll && node.querySelectorAll('.code-box code');
                    if (legacyCodeBoxes && legacyCodeBoxes.length > 0) {
                        legacyCodeBoxes.forEach((codeBlock) => {
                            Prism.highlightElement(codeBlock);
                        });
                        console.log('[Prism] Legacy CodeBox elements highlighted');
                    }
                    
                    // Check if the node itself is a code block
                    if (node.classList && node.classList.contains('code-box')) {
                        const codeBlock = node.querySelector('code');
                        if (codeBlock) {
                            Prism.highlightElement(codeBlock);
                        }
                    }
                }
            });
        });
    }
});

// Start observing the document for changes
prismObserver.observe(document.body, {
    childList: true,
    subtree: true
});

console.log('[Prism] Enhanced mutation observer started for TinyMCE compatibility');

// TinyMCE-specific Prism integration
if (typeof tinymce !== 'undefined') {
    tinymce.PluginManager.add('prismintegration', function(editor) {
        editor.on('SetContent', function() {
            setTimeout(() => {
                const contentDoc = editor.getDoc();
                const codeBlocks = contentDoc.querySelectorAll('pre code[class*="language-"]');
                codeBlocks.forEach((codeBlock) => {
                    if (window.Prism) {
                        Prism.highlightElement(codeBlock);
                    }
                });
            }, 100);
        });
    });
}

// Admin Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('admin-mobile-menu-button');
    const sidebar = document.getElementById('admin-sidebar');
    
    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !sidebar.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
        
        // Prevent clicks inside sidebar from closing it
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
</body>
</html>