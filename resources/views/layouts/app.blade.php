<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $pageTitle ?? 'Edi Purwanto\'s Blog' }}</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
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

<!-- Google Site Verification -->
<meta name="google-site-verification" content="KNzxadS9zi6eFbfi6NrALyhzxHkL6tSd9OTpcRQmeSs" />
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
    // Wrap tables in scrollable containers for mobile
    wrapTablesForMobile();
    
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

// Function to wrap tables in scrollable containers for mobile
function wrapTablesForMobile() {
    console.log('[Mobile Tables] Wrapping tables for mobile display');
    
    const tables = document.querySelectorAll('.prose table');
    tables.forEach((table) => {
        // Skip if already wrapped
        if (table.closest('.table-wrapper')) {
            return;
        }
        
        // Create wrapper div
        const wrapper = document.createElement('div');
        wrapper.className = 'table-wrapper';
        
        // Insert wrapper before table
        table.parentNode.insertBefore(wrapper, table);
        
        // Move table inside wrapper
        wrapper.appendChild(table);
        
        console.log('[Mobile Tables] Table wrapped in scrollable container');
    });
}

// Re-wrap tables when content changes
const tableObserver = new MutationObserver((mutations) => {
    let shouldReWrap = false;
    
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeType === Node.ELEMENT_NODE) {
                // Check if any tables were added
                if (node.tagName === 'TABLE' || (node.querySelectorAll && node.querySelectorAll('table').length > 0)) {
                    shouldReWrap = true;
                }
            }
        });
    });
    
    if (shouldReWrap) {
        setTimeout(() => {
            wrapTablesForMobile();
        }, 100);
    }
});

// Start observing for table changes
tableObserver.observe(document.body, {
    childList: true,
    subtree: true
});

console.log('[Mobile Tables] Table wrapper observer started');
</script>
</body>
</html>