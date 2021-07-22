@props(['category', 'img'])

<div {{ $attributes->merge(['class' => 'border-2 rounded-lg p-1 lg:p-4 m-1 cursor-pointer']) }}>
    <div>
        <img src="{{ $img }}" class="h-16 mx-auto">
    </div>
    <div class="mt-3 text-center text-xs lg:text-sm">{{ $category->name ?? $category }}</div>
</div>
