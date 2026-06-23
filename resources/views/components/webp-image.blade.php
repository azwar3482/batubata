@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'loading' => 'lazy',
    'storagePath' => null,
])

@php
    $storagePath = $storagePath ?? $src;
    $hasWebP = \App\Services\FileCompressionService::hasWebP($storagePath);
    $webpUrl = $hasWebP ? \App\Services\FileCompressionService::getWebpUrl($storagePath) : null;
    $originalUrl = \Illuminate\Support\Facades\Storage::url($storagePath);
@endphp

@if($hasWebP)
<picture>
    <source srcset="{{ $webpUrl }}" type="image/webp">
    <img src="{{ $originalUrl }}" alt="{{ $alt }}" class="{{ $class }}" loading="{{ $loading }}" {{ $attributes }}>
</picture>
@else
<img src="{{ $originalUrl }}" alt="{{ $alt }}" class="{{ $class }}" loading="{{ $loading }}" {{ $attributes }}>
@endif
