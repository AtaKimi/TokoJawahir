@props([
    'href' => '#',
])

<li class="fill-white">
    <a href="{{ $href }}" class="flex gap-2 items-center text-white">
        <div> {{ $icon }} </div>
        <p>{{ $slot }}</p>
    </a>
</li>
