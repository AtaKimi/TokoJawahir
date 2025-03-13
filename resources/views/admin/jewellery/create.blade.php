<x-layouts.admin>
    <div class="w-full mb-4">
        <x-admin.title>Tambah Perhiasan</x-admin.title>
        {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
    </div>

    <form action="{{ route('admin.jewellery.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="w-full flex flex-wrap justify-between lg:gap-4 gap-2 md:gap-3 mb-3">
            <div class="grow">
                <x-admin.form.input name="name" label="Nama Perhiasan" placeholder="Nama Perhiasan" />
                <x-admin.form.input name="price" label="Harga Perhiasan" placeholder="1000" type="number" />
                <x-admin.form.input name="quantity" label="Stok Perhiasan" placeholder="3" type="number" />
            </div>
            <div class="border hidden lg:block"></div>
            <div class="grow">
                <x-admin.form.text-area name="description" label="Deskripsi Perhiasan" placeholder="Deskripsi Perhiasan" />
                <x-admin.form.file-input name="image" label="Foto Perhiasan" placeholder="Foto Perhiasan" />
            </div>
        </div>
    
        <div class="w-full flex justify-end">
            <button class="btn btn-primary w-32" type="submit">Tambah</button>
        </div>
    </form>
</x-layouts.admin>
