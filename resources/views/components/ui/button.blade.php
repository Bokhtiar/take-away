@php
    $variantClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white focus:ring-yellow-500',
        'info' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
        'light' => 'bg-gray-200 hover:bg-gray-300 text-gray-900 focus:ring-gray-500',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white focus:ring-gray-500',
        'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 focus:ring-blue-500',
    ];
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed';
    $variantClass = $variantClasses[$variant] ?? $variantClasses['primary'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($href)
<a href="{{ $href }}" class="{{ $baseClasses }} {{ $variantClass }} {{ $sizeClass }} {{ $class }}">
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $variantClass $sizeClass $class"]) }} @if($disabled) disabled @endif>
    {{ $slot }}
</button>
@endif