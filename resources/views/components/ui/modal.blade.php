<div id="{{ $id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle @if($size === 'sm') sm:max-w-md @elseif($size === 'lg') sm:max-w-3xl @else sm:max-w-lg @endif w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @if($title || $closeable)
                <div class="flex items-center justify-between mb-4">
                    @if($title)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        {{ $title }}
                    </h3>
                    @endif
                    @if($closeable)
                    <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    @endif
                </div>
                @endif
                <div class="mt-2">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

