<div class="w-full">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="block w-full px-4 py-2.5 border {{ $error ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $class }}"
    >
        @if($placeholder)
        <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
            {{ $optionLabel }}
        </option>
        @endforeach
    </select>
    @if($error)
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
    @error($name)
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

