<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $pageTitle ?? 'Edi purwanto\'s Blog' }}</title>
<!-- TODO: For production, install Tailwind CSS as a PostCSS plugin or use the Tailwind CLI -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
@vite('resources/js/app.js')
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#4299e1", // A light blue accent
              "background-light": "#ffffff",
              "background-dark": "#101922", // Kept for potential future use, but design is light
              "text-light": "#6b7280", // Light grey text
              "text-dark": "#1f2937", // Darker text for titles/headings
            },
            fontFamily: {
              "display": ["Inter", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
@isset($metaDescription)
    <meta name="description" content="{{ $metaDescription }}">
@else
    <meta name="description" content="Edi Purwanto - Information Systems Lecturer & System Analyst. Sharing experiences, research insights, and practical approaches to system design, data-driven decision making, and software development.">
@endisset

@stack('meta')

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:title" content="{{ $pageTitle ?? 'Edi purwanto\'s Blog' }}">
@isset($metaDescription)
    <meta property="og:description" content="{{ $metaDescription }}">
@else
    <meta property="og:description" content="Edi Purwanto - Information Systems Lecturer & System Analyst. Sharing experiences, research insights, and practical approaches to system design, data-driven decision making, and software development.">
@endisset
<meta property="og:image" content="{{ asset('images/image_home.jpeg') }}">
<meta property="og:image:width" content="400">
<meta property="og:image:height" content="400">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ request()->url() }}">
<meta property="twitter:title" content="{{ $pageTitle ?? 'Edi purwanto\'s Blog' }}">
@isset($metaDescription)
    <meta property="twitter:description" content="{{ $metaDescription }}">
@else
    <meta property="twitter:description" content="Edi Purwanto - Information Systems Lecturer & System Analyst. Sharing experiences, research insights, and practical approaches to system design, data-driven decision making, and software development.">
@endisset
<meta property="twitter:image" content="{{ asset('images/image_home.jpeg') }}">
<meta property="twitter:creator" content="@edipurwanto">

@isset($favicon)
    <link rel="icon" href="{{ $favicon }}">
@else
    <link rel="icon" href="{{ asset('images/icon.png') }}">
@endisset
@isset($googleConsoleCode)
    <meta name="google-site-verification" content="{{ $googleConsoleCode }}">
@endisset
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

/* Responsive Design */
@media (max-width: 768px) {
    .code-box {
        margin: 1.5rem -1rem;
        border-radius: 0;
        border-left: none;
        border-right: none;
    }
    
    .code-box .code-box-header {
        padding: 10px 12px;
    }
    
    .code-box pre {
        padding: 12px;
    }
    
    .code-box code {
        font-size: 13px;
    }
    
    .code-box .copy-btn {
        padding: 3px 6px;
        font-size: 10px;
    }
}

/* Prose integration - IMPORTANT: Use !important to override Tailwind */
.prose .code-box {
    margin: 1.5rem 0 !important;
}

.prose .code-box pre {
    margin: 0 !important;
}

/* Ensure CodeBox styles override any conflicting utilities */
.code-box {
    all: initial;
    position: relative !important;
    background: #1a1a1a !important;
    color: #f8f8f2 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
    margin: 2rem 0 !important;
    border: 1px solid #333 !important;
    display: block !important;
}

.code-box .code-box-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: #2d2d2d !important;
    padding: 12px 16px !important;
    border-bottom: 1px solid #444 !important;
}

.code-box .code-box-controls {
    display: flex !important;
    gap: 8px !important;
}

.code-box .code-box-dot {
    width: 12px !important;
    height: 12px !important;
    border-radius: 50% !important;
}

.code-box .code-box-dot.red {
    background: #ff5f56 !important;
}

.code-box .code-box-dot.yellow {
    background: #ffbd2e !important;
}

.code-box .code-box-dot.green {
    background: #27c93f !important;
}

.code-box .code-box-info {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}

.code-box .code-box-language {
    color: #888 !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.code-box .copy-btn {
    background: transparent !important;
    color: #888 !important;
    border: 1px solid #555 !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    font-size: 11px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-weight: 500 !important;
}

.code-box .copy-btn:hover {
    color: #fff !important;
    border-color: #777 !important;
    background: rgba(255, 255, 255, 0.1) !important;
}

.code-box pre {
    margin: 0 !important;
    padding: 16px !important;
    overflow-x: auto !important;
    background: transparent !important;
    border: none !important;
    display: block !important;
}

.code-box code {
    background: transparent !important;
    border: none !important;
    font-family: 'Fira Code', 'Monaco', 'Consolas', 'Ubuntu Mono', monospace !important;
    font-size: 14px !important;
    line-height: 1.5 !important;
    color: #f8f8f2 !important;
    display: block !important;
}

/* Scrollbar styling for code blocks */
.code-box pre::-webkit-scrollbar {
    height: 8px;
}

.code-box pre::-webkit-scrollbar-track {
    background: #2d2d2d;
}

.code-box pre::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 4px;
}

.code-box pre::-webkit-scrollbar-thumb:hover {
    background: #666;
}
</style>

<!-- Custom Article Content Styles -->
<style>
/* Table of Content Styling */
.prose .article-toc {
    @apply bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-8;
}

.prose .article-toc h2 {
    @apply text-sm font-bold uppercase tracking-wide text-primary mb-4 border-b border-gray-200 dark:border-gray-700 pb-2;
}

.prose .article-toc ul {
    @apply space-y-2 text-sm;
}

.prose .article-toc li {
    @apply relative pl-4 border-l-2 border-gray-200 dark:border-gray-600 hover:border-primary transition-colors duration-200;
}

.prose .article-toc li::before {
    content: '';
    @apply absolute left-[-6px] top-4 w-2 h-2 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200;
}

.prose .article-toc a {
    @apply text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors duration-200 flex items-center gap-2;
}

.prose .article-toc .toc-level-2 { @apply ml-0; }
.prose .article-toc .toc-level-3 { @apply ml-4; }
.prose .article-toc .toc-level-4 { @apply ml-8; }
.prose .article-toc .toc-level-5 { @apply ml-12; }
.prose .article-toc .toc-level-6 { @apply ml-16; }

/* Table Styling */
.prose table {
    @apply w-full border-collapse rounded-lg overflow-hidden shadow-sm mb-6 bg-white dark:bg-gray-800;
}

.prose th {
    @apply bg-gray-50 dark:bg-gray-700 text-left font-semibold text-gray-900 dark:text-gray-100 px-4 py-3 border-b border-gray-200 dark:border-gray-600;
}

.prose td {
    @apply px-4 py-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300;
}

.prose tr:last-child td {
    @apply border-b-0;
}

.prose tr:hover {
    @apply bg-gray-50 dark:bg-gray-750 transition-colors duration-150;
}

/* Striped table rows */
.prose tbody tr:nth-child(even) {
    @apply bg-gray-50 dark:bg-gray-750;
}

.prose tbody tr:nth-child(odd) {
    @apply bg-white dark:bg-gray-800;
}

/* UL/LI Styling */
.prose ul {
    @apply space-y-2 mb-4 text-gray-700 dark:text-gray-300;
}

.prose ol {
    @apply space-y-2 mb-4 text-gray-700 dark:text-gray-300 pl-6;
}

.prose li {
    @apply relative pl-6;
}

.prose ul li::before {
    content: '';
    @apply absolute left-0 top-4 w-2 h-2 bg-primary rounded-full;
}

.prose ol li::marker {
    @apply text-primary font-semibold;
}

.prose ul ul,
.prose ol ul,
.prose ul ol,
.prose ol ol {
    @apply mt-2 ml-6;
}

.prose ul li::marker {
    content: '•';
    @apply text-primary font-semibold mr-2;
}

.prose li p {
    @apply mb-0;
}

/* Heading Styling */
.prose h1 {
    @apply text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4 mt-8 pb-2 border-b-2 border-gray-200 dark:border-gray-700;
}

.prose h2 {
    @apply text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-3 mt-6 pb-1 border-b border-gray-200 dark:border-gray-700;
}

.prose h3 {
    @apply text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2 mt-5;
}

.prose h4 {
    @apply text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 mt-4;
}

.prose h5 {
    @apply text-base font-semibold text-gray-700 dark:text-gray-300 mb-2 mt-3;
}

.prose h6 {
    @apply text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2 mt-3;
}

/* Heading anchor links */
.prose h1 > a,
.prose h2 > a,
.prose h3 > a,
.prose h4 > a,
.prose h5 > a,
.prose h6 > a {
    @apply opacity-0 hover:opacity-100 transition-opacity duration-200 ml-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300;
}

.prose h1:hover > a,
.prose h2:hover > a,
.prose h3:hover > a,
.prose h4:hover > a,
.prose h5:hover > a,
.prose h6:hover > a {
    @apply opacity-100;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .prose table {
        @apply text-sm;
    }
    
    .prose th,
    .prose td {
        @apply px-3 py-2;
    }
    
    .prose h1 {
        @apply text-2xl;
    }
    
    .prose h2 {
        @apply text-xl;
    }
    
    .prose h3 {
        @apply text-lg;
    }
    
    .prose h4 {
        @apply text-base;
    }
}

/* Print styles */
@media print {
    .prose .article-toc {
        @apply bg-gray-50 border-gray-300;
    }
    
    .prose table {
        @apply shadow-none border border-gray-300;
    }
    
    .prose th,
    .prose td {
        @apply border-gray-300;
    }
}
</style>
</head>
<body class="font-display bg-background-light text-text-dark">
<div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<div class="px-4 sm:px-8 md:px-16 lg:px-24 xl:px-40 flex flex-1 justify-center py-5">
<div class="layout-content-container flex flex-col w-full max-w-[960px] flex-1">
@include('components.header')

<main>
    @yield('content')
</main>

@include('components.footer')
</div>
</div>
</div>
</div>
<!-- Prism.js for syntax highlighting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markdown.min.js"></script>

<!-- Copy button functionality for both CodeBox and TinyMCE -->
<script>
document.addEventListener('click', async (e) => {
    // Handle old CodeBox copy buttons
    if (e.target.classList.contains('copy-btn')) {
        console.log('[Copy] CodeBox copy button clicked');
        try {
            const codeBox = e.target.closest('.code-box');
            if (codeBox) {
                const code = codeBox.querySelector('pre').innerText;
                await navigator.clipboard.writeText(code);
                
                // Show success toast
                showToast('✅ Kode berhasil disalin!');
                console.log('[Copy] CodeBox code copied successfully');
            }
        } catch (error) {
            console.error('[Copy] Failed to copy CodeBox code:', error);
            showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
        }
    }
    
    // Handle TinyMCE code sample copy buttons
    if (e.target.classList.contains('mce-copy') || e.target.closest('.mce-copy')) {
        console.log('[Copy] TinyMCE copy button clicked');
        try {
            const codeBlock = e.target.closest('pre') || e.target.closest('.mce-content-body pre');
            if (codeBlock) {
                const code = codeBlock.textContent || codeBlock.innerText;
                await navigator.clipboard.writeText(code);
                
                // Show success toast
                showToast('✅ Kode berhasil disalin!');
                console.log('[Copy] TinyMCE code copied successfully');
            }
        } catch (error) {
            console.error('[Copy] Failed to copy TinyMCE code:', error);
            showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
        }
    }
    
    // Handle any other code blocks (fallback)
    if (e.target.closest('pre[class*="language-"]') || e.target.closest('.prose pre')) {
        console.log('[Copy] Generic code block clicked');
        try {
            const codeBlock = e.target.closest('pre') || e.target.closest('.prose pre');
            if (codeBlock) {
                const code = codeBlock.textContent || codeBlock.innerText;
                await navigator.clipboard.writeText(code);
                
                // Show success toast
                showToast('✅ Kode berhasil disalin!');
                console.log('[Copy] Generic code copied successfully');
            }
        } catch (error) {
            console.error('[Copy] Failed to copy generic code:', error);
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

// Initialize Prism.js when DOM is ready
window.addEventListener('DOMContentLoaded', () => {
    if (window.Prism) {
        Prism.highlightAll();
        console.log('[Prism] Syntax highlighting initialized');
        
        // Re-highlight CodeBox elements specifically
        const codeBoxes = document.querySelectorAll('.code-box code');
        codeBoxes.forEach((codeBlock) => {
            if (codeBlock && Prism) {
                Prism.highlightElement(codeBlock);
                console.log('[Prism] CodeBox highlighted:', codeBlock.className);
            }
        });
        
        // Also add copy buttons to any existing TinyMCE code blocks immediately
        const existingTinyMCECodeBlocks = document.querySelectorAll('pre[class*="language-"]');
        existingTinyMCECodeBlocks.forEach((codeBlock) => {
            // Skip if already has copy button
            if (codeBlock.querySelector('.copy-button-container')) {
                return;
            }
            
            // Create copy button container
            const copyContainer = document.createElement('div');
            copyContainer.className = 'copy-button-container';
            copyContainer.style.cssText = `
                position: absolute;
                top: 8px;
                right: 8px;
                z-index: 10;
            `;
            
            // Create copy button
            const copyBtn = document.createElement('button');
            copyBtn.className = 'copy-btn';
            copyBtn.innerHTML = '📋';
            copyBtn.title = 'Salin kode';
            copyBtn.style.cssText = `
                background: rgba(0, 0, 0, 0.7);
                color: #fff;
                border: 1px solid #555;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s ease;
                opacity: 0;
            `;
            
            // Add hover effects
            copyBtn.addEventListener('mouseenter', () => {
                copyBtn.style.opacity = '1';
                copyBtn.style.background = 'rgba(0, 123, 255, 0.8)';
            });
            
            copyBtn.addEventListener('mouseleave', () => {
                copyBtn.style.opacity = '0';
                copyBtn.style.background = 'rgba(0, 0, 0, 0.7)';
            });
            
            // Add click handler
            copyBtn.addEventListener('click', async (e) => {
                e.stopPropagation();
                try {
                    const code = codeBlock.textContent || codeBlock.innerText;
                    await navigator.clipboard.writeText(code);
                    showToast('✅ Kode berhasil disalin!');
                    console.log('[Copy] TinyMCE code copied successfully');
                } catch (error) {
                    console.error('[Copy] Failed to copy TinyMCE code:', error);
                    showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
                }
            });
            
            copyContainer.appendChild(copyBtn);
            
            // Make code block relative positioned
            if (codeBlock.style.position !== 'relative') {
                codeBlock.style.position = 'relative';
            }
            
            // Add copy button to code block
            codeBlock.appendChild(copyContainer);
            
            console.log('[Prism] Copy button added to existing TinyMCE code block');
        });
    }
    
    // Add copy buttons to TinyMCE code blocks after a short delay
    setTimeout(() => {
        addCopyButtonsToCodeBlocks();
    }, 1000);

    // Define the missing addCopyButtonsToCodeBlocks function
    function addCopyButtonsToCodeBlocks() {
        console.log('[CodeBlocks] Adding copy buttons to code blocks');
        
        const codeBlocks = document.querySelectorAll('pre[class*="language-"], .prose pre');
        codeBlocks.forEach((codeBlock) => {
            // Skip if already has copy button
            if (codeBlock.querySelector('.copy-button-container')) {
                return;
            }
            
            // Create copy button container
            const copyContainer = document.createElement('div');
            copyContainer.className = 'copy-button-container';
            copyContainer.style.cssText = `
                position: absolute;
                top: 8px;
                right: 8px;
                z-index: 10;
            `;
            
            // Create copy button
            const copyBtn = document.createElement('button');
            copyBtn.className = 'copy-btn';
            copyBtn.innerHTML = '📋';
            copyBtn.title = 'Salin kode';
            copyBtn.style.cssText = `
                background: rgba(0, 0, 0, 0.7);
                color: #fff;
                border: 1px solid #555;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s ease;
                opacity: 0;
            `;
            
            // Add hover effects
            copyBtn.addEventListener('mouseenter', () => {
                copyBtn.style.opacity = '1';
                copyBtn.style.background = 'rgba(0, 123, 255, 0.8)';
            });
            
            copyBtn.addEventListener('mouseleave', () => {
                copyBtn.style.opacity = '0';
                copyBtn.style.background = 'rgba(0, 0, 0, 0.7)';
            });
            
            // Add click handler
            copyBtn.addEventListener('click', async (e) => {
                e.stopPropagation();
                try {
                    const code = codeBlock.textContent || codeBlock.innerText;
                    await navigator.clipboard.writeText(code);
                    showToast('✅ Kode berhasil disalin!');
                    console.log('[Copy] Code copied successfully');
                } catch (error) {
                    console.error('[Copy] Failed to copy code:', error);
                    showToast('❌ Gagal menyalin kode. Silakan coba lagi.', 'error');
                }
            });
            
            copyContainer.appendChild(copyBtn);
            
            // Make code block relative positioned
            if (codeBlock.style.position !== 'relative') {
                codeBlock.style.position = 'relative';
            }
            
            // Add copy button to code block
            codeBlock.appendChild(copyContainer);
            
            console.log('[CodeBlocks] Copy button added to code block');
        });
    }
});

// Re-initialize Prism.js when content changes (for dynamic content)
const prismObserver = new MutationObserver((mutations) => {
    if (window.Prism) {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    // Check for CodeBox elements
                    const codeBoxes = node.querySelectorAll && node.querySelectorAll('.code-box code');
                    if (codeBoxes && codeBoxes.length > 0) {
                        codeBoxes.forEach((codeBlock) => {
                            Prism.highlightElement(codeBlock);
                        });
                        console.log('[Prism] CodeBox re-highlighted after content change');
                    }
                    
                    // Also check if the node itself is a code block
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

console.log('[Prism] Mutation observer started for dynamic content');
</script>
</body>
</html>