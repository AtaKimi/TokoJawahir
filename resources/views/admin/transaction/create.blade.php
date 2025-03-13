<x-layouts.admin>

    <div class="pb-16">
        <div class="w-full gap-2 p-4 items-center">
            <div>
                <x-admin.title>Keranjang</x-admin.title>
                {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $user) }}
            </div>
        </div>
        <livewire:admin.transaction :user="$user" />
    </div>
</x-layouts.admin>
