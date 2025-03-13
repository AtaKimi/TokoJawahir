@props([
    'href' => '#',
])

<li>
    <a  href="{{ $href }}" class="flex gap-2 items-center">
        <div> {{ $icon }} </div>
        <p>{{ $slot }}</p>
    </a>
</li>
