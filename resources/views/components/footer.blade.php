<footer class="mt-16 border-t border-gray-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="flex items-center gap-4">
                <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.286 2.863 7.913 6.837 9.163.5.092.682-.217.682-.482 0-.237-.009-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.03-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.378.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .267.18.577.688.48C19.137 19.913 22 16.286 22 12c0-5.523-4.477-10-10-10z" fill-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">GitHub</span>
                </a>
                <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                    </svg>
                    <span class="sr-only">LinkedIn</span>
                </a>
            </div>
            <p class="text-sm text-gray-400">
                © {{ date('Y') }} Edi Purwanto. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<script>
function copyCode() {
  const code = document.getElementById("codeBlock").innerText;
  navigator.clipboard.writeText(code);
  alert("Kode berhasil disalin!");
}
</script>