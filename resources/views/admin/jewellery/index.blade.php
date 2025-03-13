<x-layouts.admin>
    {{-- <button class="btn" onclick="my_modal_2.showModal()">open modal</button> --}}
    <dialog id="my_modal_2" class="modal" x-data="{ image: 'test' }" @set-image.window="image = $event.detail">
        <div class="modal-box">
            <img x-bind:src="image" alt="" class="w-full">
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>List Perhiasan</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
        <a href="{{ route('admin.jewellery.create') }}" class="btn btn-primary text-lg fill-white">
            <div class="flex justify-center items-center">
                <p class="">Tambah</p>
            </div>
        </a>
    </div>
    <x-admin.form.search />
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr class="text-base text-gray-600">
                    <th>Perhiasan</th>
                    <th>Deskripsi Singkat</th>
                    <th>Qty</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->

                @forelse ($jewelleries as $jewellery)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3" x-data>
                                <div class="avatar">
                                    <button class="mask mask-squircle h-12 w-12 btn btn-square btn-ghost"
                                        onclick="my_modal_2.showModal()"
                                        x-on:click="$dispatch('set-image', '{{ $jewellery->getFirstMediaUrl('image') }}')">
                                        <img src="{{ $jewellery->getFirstMediaUrl('image') }}" />
                                    </button>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $jewellery->name }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ 'Rp. ' . number_format($jewellery->price, 2, ',', '.') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="max-w-xs">
                            {{ Str::words($jewellery->description, 12) }}
                        </td>
                        <td>{{ $jewellery->quantity }}</td>
                        <th>
                            <a href="{{ route('admin.jewellery.edit', $jewellery) }}"
                                class="btn btn-secondary btn-sm">Edit</a>
                        </th>
                        <th>
                            <form action="{{ route('admin.jewellery.destroy', $jewellery->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type=""
                                    class="btn btn-ghost glass bg-red-500 text-white btn-sm">Hapus</button>
                            </form>
                        </th>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3">
        {{ $jewelleries->links('pagination::simple-tailwind') }}
    </div>
</x-layouts.admin>
