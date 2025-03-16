<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Keranjang</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $user) }}
        </div>
        <x-admin.user.bubble img="{{ $user->getFirstMediaUrl('image') }}" name="{{ $user->name }}"
            phone="{{ $user->phone }}" />
    </div>
    <livewire:admin.buy-back.cart :user="$user" />
</x-layouts.admin>
