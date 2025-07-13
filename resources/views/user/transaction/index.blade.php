<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>List Transaksi</x-admin.title>
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
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>
                            {{ 'Rp. ' . number_format($transaction->total, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ $transaction->created_at }}
                        </td>
                        <td>
                            <a href="{{ route('user.transaction.show', $transaction) }}"
                                class="btn btn-success w-full">Success</a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3">
        {{ $transactions->links('pagination::simple-tailwind') }}
    </div>
</x-layouts.admin>
