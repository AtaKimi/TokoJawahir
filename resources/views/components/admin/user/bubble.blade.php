@props([
    'img' => '-',
    'name' => '-',
    'phone' => '-',
])

<div class="flex items-center gap-3">
    <div>
        <div class="font-bold">{{ $name }}</div>
        <div class="text-sm opacity-50">{{ $phone }}</div>
    </div>
    <div class="avatar">
        <div class="mask mask-squircle h-12 w-12">
            <img src="{{ $img }}" alt="Avatar Tailwind CSS Component" />
        </div>
    </div>
</div>
