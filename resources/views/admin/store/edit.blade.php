<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Profile</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
    </div>

    <form action="{{ route('admin.store.update') }}" method="post" class="flex flex-col">
        @csrf
        @method('PUT')
        <x-admin.form.input name="name" label="Nama" placeholder="Daisy" value="{{ $store->name }}" />
        <x-admin.form.input name="email" label="Email" placeholder="daisy@site.com" value="{{ $store->email }}" />
        <x-admin.form.input name="phone" label="Nomor Telpon" placeholder="085327394829" type="text"
            value="{{ $store->phone }}" />
        <x-admin.form.text-area name="address" label="Alamat" placeholder="Alamat" value="{{ $store->address }}" />
        <div class="w-full flex justify-end">
            <button class="btn btn-primary w-32" type="submit">Simpan</button>
        </div>
    </form>
</x-layouts.admin>
