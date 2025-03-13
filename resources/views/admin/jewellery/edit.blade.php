<x-layouts.admin>
    <div class="w-full mb-4">
        <x-admin.title>Edit Perhiasan</x-admin.title>
        {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $jewellery) }}
    </div>

    <form action="{{ route('admin.jewellery.update', $jewellery) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="w-full flex flex-wrap justify-between lg:gap-4 gap-2 md:gap-3 mb-3">
            <div class="grow">
                <x-admin.form.input name="name" label="Nama Perhiasan" placeholder="Nama Perhiasan"
                    value="{{ $jewellery->name }}" />
                <x-admin.form.input name="price" label="Harga Perhiasan" placeholder="1000" type="number"
                    value="{{ $jewellery->price }}" />
                <x-admin.form.input name="quantity" label="Stok Perhiasan" placeholder="3" type="number"
                    value="{{ $jewellery->quantity }}" />
            </div>
            <div class="border hidden lg:block"></div>
            <div class="grow">
                <x-admin.form.text-area name="description" label="Deskripsi Perhiasan" placeholder="Deskripsi Perhiasan"
                    value="{{ $jewellery->description }}" />
                <x-admin.form.file-input name="image" label="Foto Perhiasan" placeholder="Foto Perhiasan" />
                <div class="flex items-center gap-3">
                    <img src="{{$jewellery->getFirstMediaUrl('image')}}" alt="" class="w-24 rounded-md">
                    <h1 class="text-base font-bold tracking-wide">Foto Terkahir</h1>
                </div>
            </div>
        </div>

        <div class="w-full flex justify-end">
            <button class="btn btn-primary w-32" type="submit">Tambah</button>
        </div>
    </form>
</x-layouts.admin>
