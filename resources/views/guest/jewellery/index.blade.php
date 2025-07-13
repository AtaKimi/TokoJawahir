<x-layouts.guest>

    <div class="px-6 flex flex-col gap-4 text-gray-800 tracking-wider">
        <div class="w-full flex flex-wrap justify-between gap-2 items-center">
            <div>
                <h1 class="text-xl font-medium tracking-wider">Perhiasan</h1>
                {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
            </div>
            <x-admin.form.search />
        </div>
        <p class="text-lg tracking-wider">Perhiasan</p>

        <div class="flex flex-wrap gap-4 justify-start">
            @forelse ($jewelleries as $jewellery)
                <a href="{{ route('guest.jewellery.show', $jewellery->id) }}"
                    class="grow hover:backdrop-opacity-50 hover:brightness-90 hover:rounded-md hover:cursor-pointer">
                    <div class="w-full aspect-square rounded-t-md">
                        <img src="{{ $jewellery->getFirstMediaUrl('image') }}" alt=""
                            class="w-full h-full rounded-sm">
                    </div>
                    <div class="w-full p-2">
                        <p class="text-md text-center tracking-wide">{{ $jewellery->name }}</p>
                        <p class="text-base text-gray-500 text-center tracking-wide">Rp.
                            {{ number_format($jewellery->price, 2, ',', '.') }}</p>
                    </div>
                    </d>
                @empty
            @endforelse
        </div>
        <div>
            {{ $jewelleries->links('pagination::simple-tailwind') }}
        </div>
    </div>

</x-layouts.guest>
