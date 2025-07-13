<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Profile</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
    </div>

    <div class="flex flex-col gap-6">
        <div class="flex justify-between items-center">
            <div class="avatar">
                <div class="w-24 rounded-full">
                    <img src="{{ $user->getFirstMediaUrl('image') ?? '' }}" />
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.profile.edit') }}"
                    class="w-10 h-10 fill-white bg-emerald-500 rounded-md
                    flex items-center justify-center">
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
                </a>
                <button onclick="edit_profile_image.showModal()"
                    class="w-10 h-10 fill-white bg-primary rounded-md flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                    </svg>
                </button>
            </div>
        </div>
        <div>
            <div class="overflow-x-auto">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td class="w-full text-wide">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telpon</th>
                            <td class="w-full text-wide">{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td class="w-full text-wide">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td class="w-full text-wide">{{ $user->address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <dialog id="edit_profile_image" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box flex flex-col gap-4">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Edit Foto Profil</h3>
            <form action="{{ route('user.profile.update-photo') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex justify-between gap-4">
                    <div class="avatar">
                        <div class="w-24 rounded">
                            <img src="{{ $user->getFirstMediaUrl('image') }}" />
                        </div>
                    </div>
                    <x-admin.form.file-input name="image" label="Foto Profil" placeholder="File" />
                </div>
                <div class="modal-action">
                    <button class="btn btn-primary w-24" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.admin>


<!-- Open the modal using ID.showModal() method -->
