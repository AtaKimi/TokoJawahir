<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Toko</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
        <a href="{{ route('admin.store.edit') }}"
            class="w-10 h-10 fill-white bg-emerald-500 rounded-md
        flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24"
                width="24">
                <g>
                    <rect fill="none" height="24" width="24" />
                </g>
                <g>
                    <g>
                        <g>
                            <polygon points="3,17.25 3,21 6.75,21 17.81,9.94 14.06,6.19" />
                        </g>
                        <g>
                            <path
                                d="M20.71,5.63l-2.34-2.34c-0.39-0.39-1.02-0.39-1.41,0l-1.83,1.83l3.75,3.75l1.83-1.83C21.1,6.65,21.1,6.02,20.71,5.63z" />
                        </g>
                    </g>
                </g>
            </svg>
        </a>
    </div>

    <div>
        <div class="overflow-x-auto">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td class="w-full text-wide">{{ $store->name }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telpon</th>
                        <td class="w-full text-wide">{{ $store->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td class="w-full text-wide">{{ $store->email }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td class="w-full text-wide">{{ $store->address }}</td>
                    </tr>
                    <tr>
                        <th>Persentase Beli Kembali</th>
                        <td class="w-full text-wide flex justify-between">
                            <span>{{ $buy_back_percentage->percentage }}%</span>
                            <button onclick="edit_buy_back_percentage.showModal()"
                                class="w-10 h-10 fill-white bg-primary rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24"
                                    viewBox="0 0 24 24" width="24">
                                    <g>
                                        <rect fill="none" height="24" width="24" />
                                    </g>
                                    <g>
                                        <g>
                                            <g>
                                                <polygon points="3,17.25 3,21 6.75,21 17.81,9.94 14.06,6.19" />
                                            </g>
                                            <g>
                                                <path
                                                    d="M20.71,5.63l-2.34-2.34c-0.39-0.39-1.02-0.39-1.41,0l-1.83,1.83l3.75,3.75l1.83-1.83C21.1,6.65,21.1,6.02,20.71,5.63z" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <dialog id="edit_buy_back_percentage" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box flex flex-col gap-4">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Edit Foto Profil</h3>
            <form action="{{ route('admin.store.update-buyback-percentage') }}" method="post">
                @csrf
                @method('PUT')
                <x-admin.form.input name="percentage" label="Persentase" placeholder="10"
                    value="{{ $buy_back_percentage->percentage }}" />
                <div class="modal-action">
                    <button class="btn btn-primary w-24" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.admin>
