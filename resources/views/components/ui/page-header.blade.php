<div class="{{ $class ?? '' }} shadow-sm bg-white rounded py-4 px-2">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
    @if($description)
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            {{ $description }}
        </p>
    @endif
</div>

