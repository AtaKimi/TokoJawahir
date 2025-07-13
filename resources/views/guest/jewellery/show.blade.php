<x-layouts.guest>
    <div class="px-6 flex flex-col gap-4 text-gray-800 tracking-wider">
        <div class="w-full flex justify-between gap-2 items-center">
            <div>
                <h1 class="text-xl font-medium tracking-wider">Perhiasan</h1>
                {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $jewellery) }}
            </div>
        </div>

        <div class="flex gap-8 flex-wrap">
            <div class="basis-1 grow lg:basis-1/2 min-w-64 max-w-lg aspect-square rounded">
                <img src="{{ $jewellery->getFirstMediaUrl('image') }}" alt=""
                    class="w-full h-full object-cover rounded">
            </div>
            <div class="basis-1 grow lg:basis-1/2 flex flex-col gap-3">
                <div class="flex flex-col gap-2">
                    <p class="text-4xl tracking-widest">{{ $jewellery->name }}</p>
                    <p class="text-2xl tracking-wider text-gray-600">Rp.
                        {{ number_format($jewellery->price, 2, '.', ',') }}
                </div>
                <hr>
                </p>
                <p class="text-lg tracking-widest">Stok: {{ $jewellery->quantity }}</p>
                <p class="text-lg tracking-widest leading-2">Deskripsi:</p>
                <p class="text-md tracking-widest leading-2">{{ $jewellery->description }}</p>
            </div>
        </div>
    </div>
</x-layouts.guest>
