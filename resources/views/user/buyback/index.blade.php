<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>List Beli Kembali</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi/Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buy_backs as $buy_back)
                    <tr>
                        <td>
                            {{ 'Rp. ' . number_format($buy_back->total, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ $buy_back->created_at }}
                        </td>
                        <td>
                            <a href="{{ route('user.buyback.show', $buy_back) }}"
                                class="btn btn-success w-full">Success</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3">
        {{ $buy_backs->links('pagination::simple-tailwind') }}
    </div>
</x-layouts.admin>
