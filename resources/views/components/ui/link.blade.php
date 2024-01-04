@props([
    'href',
    'block' => false,
    'size' => 'lg',
    'style' => 'primary',
    'class' => '',
])

@php
    $sizes = [
        'lg' => 'px-5 py-2.5',
        'md' => 'px-4 py-2',
    ];

    $styles = [
        'outline' => 'bg-white border-2 border-black hover:bg-gray-100 text-black',
        'primary' => 'bg-black text-white hover:bg-gray-800 border-2 border-transparent',
        'inverted' => 'bg-white text-black border-2 border-transparent',
        'muted' => 'bg-gray-100 hover:bg-gray-200 border-2 border-transparent',
    ];
@endphp

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'flex items-center rounded text-center transition focus-visible:ring-2 ring-offset-2 ring-gray-200' . ($block ? ' w-full' : '') . ' ' . $sizes[$size] . ' ' . $styles[$style] . ' ' . $class,
]) }}>
    {{ $slot }}
</a>
