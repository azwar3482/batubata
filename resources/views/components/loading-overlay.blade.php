@props(['id' => 'loading-overlay'])

<div id="{{ $id }}" x-show="loading" x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-2xl flex flex-col items-center gap-3 max-w-xs mx-4">
        <div class="relative w-12 h-12">
            <div class="absolute inset-0 rounded-full border-4 border-blue-100 dark:border-slate-700"></div>
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-blue-600 animate-spin"></div>
        </div>
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center" x-text="loadingText || 'Memproses...'"></p>
    </div>
</div>
