@props(['type' => 'info', 'closeable' => false])

@php
    $classes = [
        'success' => 'bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-700',
        'error' => 'bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700',
        'warning' => 'bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 text-yellow-700',
        'info' => 'bg-gradient-to-r from-pastel-blue/20 to-soft-blue/20 border-l-4 border-accent-blue text-gray-700',
    ];
    
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-times-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg p-4 mb-4 shadow-sm ' . $classes[$type] . ' animate-fade-in']) }}>
    <div class="flex items-start">
        <i class="fas {{ $icons[$type] }} mr-3 mt-0.5 text-lg"></i>
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($closeable)
            <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>