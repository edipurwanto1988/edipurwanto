<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $pageTitle ?? 'Edi Purwanto\'s Blog' }}</title>
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
<meta property="og:title" content="{{ $pageTitle ?? 'Edi Purwanto\'s Blog' }}">
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
<meta property="twitter:title" content="{{ $pageTitle ?? 'Edi Purwanto\'s Blog' }}">
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
    background-color: #ECFDF5;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #A7F3D0;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.prose .article-toc h2 {
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #065F46;
    margin-bottom: 1rem;
    border-bottom: 1px solid #A7F3D0;
    padding-bottom: 0.5rem;
}

.prose .article-toc ul {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.prose .article-toc li {
    position: relative;
    padding-left: 1rem;
    border-left: 2px solid #A7F3D0;
    transition: border-color 0.2s ease-in-out;
}

.prose .article-toc li:hover {
    border-color: #065F46;
}

.prose .article-toc li::before {
    content: '';
    position: absolute;
    left: -0.375rem;
    top: 1rem;
    width: 0.5rem;
    height: 0.5rem;
    background-color: #065F46;
    border-radius: 9999px;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

.prose .article-toc li:hover::before {
    opacity: 1;
}

.prose .article-toc a {
    color: rgb(31 41 55 / var(--tw-text-opacity, 1));
    transition: color 0.2s ease-in-out;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.prose .article-toc a:hover {
    color: #065F46;
}

.prose .article-toc .toc-level-2 {
    margin-left: 0;
}

.prose .article-toc .toc-level-3 {
    margin-left: 1rem;
}

.prose .article-toc .toc-level-4 {
    margin-left: 2rem;
}

.prose .article-toc .toc-level-5 {
    margin-left: 3rem;
}

.prose .article-toc .toc-level-6 {
    margin-left: 4rem;
}

/* Table Styling */
.prose table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    background-color: white;
}

.prose th {
    background-color: #374151;
    text-align: left;
    font-weight: 600;
    color: #FFFFFF;
    padding: 1rem;
    border-bottom: 1px solid #6B7280;
}

.prose td {
    padding: 1rem;
    border-bottom: 1px solid #6B7280;
    color: #111827;
}

.prose tr:last-child td {
    border-bottom: none;
}

.prose tr:hover {
    background-color: #E5E7EB;
    transition: background-color 0.15s ease-in-out;
}

/* Striped table rows */
.prose tbody tr:nth-child(even) {
    background-color: #F3F4F6;
}

.prose tbody tr:nth-child(odd) {
    background-color: #F9FAFB;
}

/* UL/LI Styling */
.prose ul {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: rgb(31 41 55 / var(--tw-text-opacity, 1));
}

.prose ol {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: rgb(31 41 55 / var(--tw-text-opacity, 1));
    padding-left: 1.5rem;
}

.prose li {
    position: relative;
    padding-left: 1.5rem;
    color: rgb(31 41 55 / var(--tw-text-opacity, 1));
    margin-left: 17px;
}

.prose ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 1rem;
    width: 0.5rem;
    height: 0.5rem;
    background-color: #065F46;
    border-radius: 9999px;
}

.prose ol li::marker {
    color: #065F46;
    font-weight: 600;
}

.prose ul ul,
.prose ol ul,
.prose ul ol,
.prose ol ol {
    margin-top: 0.5rem;
    margin-left: 1.5rem;
}

.prose ul li::marker {
    content: '•';
    color: #065F46;
    font-weight: 600;
    margin-right: 0.5rem;
}

.prose li p {
    margin-bottom: 0;
}

/* Heading Styling */
.prose h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1E3A8A;
    margin-bottom: 1rem;
    margin-top: 2rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
    border-color: #374151;
}

.prose h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2563EB;
    margin-bottom: 0.75rem;
    margin-top: 1.5rem;
    padding-bottom: 0.25rem;
    border-bottom: 1px solid #e5e7eb;
    border-color: #374151;
}

.prose h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #3B82F6;
    margin-bottom: 0.5rem;
    margin-top: 1.25rem;
}

.prose h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #0E7490;
    margin-bottom: 0.5rem;
    margin-top: 1rem;
}

.prose h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #06B6D4;
    margin-bottom: 0.5rem;
    margin-top: 0.75rem;
}

.prose h6 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #22D3EE;
    margin-bottom: 0.5rem;
    margin-top: 0.75rem;
}

/* Heading anchor links */
.prose h1 > a,
.prose h2 > a,
.prose h3 > a,
.prose h4 > a,
.prose h5 > a,
.prose h6 > a {
    opacity: 0;
    margin-left: 0.5rem;
    color: #9ca3af;
    transition: opacity 0.2s ease-in-out;
}

.prose h1 > a:hover,
.prose h2 > a:hover,
.prose h3 > a:hover,
.prose h4 > a:hover,
.prose h5 > a:hover,
.prose h6 > a:hover {
    color: #9ca3af;
}

.prose h1:hover > a,
.prose h2:hover > a,
.prose h3:hover > a,
.prose h4:hover > a,
.prose h5:hover > a,
.prose h6:hover > a {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .prose table {
        font-size: 0.875rem;
    }
    
    .prose th,
    .prose td {
        padding: 0.75rem 0.75rem;
    }
    
    .prose h1 {
        font-size: 1.5rem;
    }
    
    .prose h2 {
        font-size: 1.25rem;
    }
    
    .prose h3 {
        font-size: 1.125rem;
    }
    
    .prose h4 {
        font-size: 1rem;
    }
}

/* Print styles */
@media print {
    .prose .article-toc {
        background-color: #F9FAFB;
        border-color: #6B7280;
    }
    
    .prose table {
        box-shadow: none;
        border: 1px solid #6B7280;
    }
    
    .prose th,
    .prose td {
        border-color: #6B7280;
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