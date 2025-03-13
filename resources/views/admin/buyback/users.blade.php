<x-layouts.admin>
    <div class="w-full gap-2 p-4 items-center">
        <div>
            <x-admin.title>List User</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
    </div>
    <x-admin.form.search />
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr class="text-base text-gray-600">
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Nomor Telpon</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $user->getFirstMediaUrl('image') }}" />
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="max-w-xs">
                            {{ $user->name }}
                        </td>
                        <td>{{ $user->phone }}</td>
                        <th>
                            @if (!$user->buybacks->count() > 0)
                                <a href="{{ route('admin.buyback.create', $user) }}"
                                    class="btn btn-primary btn-sm w-full">Buat Beli Kembali</a>
                            @else
                                <a href="{{ route('admin.buyback.create', $user) }}"
                                    class="btn btn-secondary btn-sm w-full">Edit Beli Kembali</a>
                            @endif
                        </th>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3">
        {{ $users->links('pagination::simple-tailwind') }}
    </div>
</x-layouts.admin>
