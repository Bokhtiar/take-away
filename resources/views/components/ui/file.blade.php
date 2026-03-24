<div class="w-full">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    <div class="relative">
        <input
            type="file"
            id="{{ $id }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($accept) accept="{{ $accept }}" @endif
            @if($multiple) multiple @endif
            class="block w-full text-sm text-gray-900 dark:text-gray-300 border {{ $error ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg cursor-pointer bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $class }}"
        >
    </div>
    @if($error)
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
    @error($name)
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

