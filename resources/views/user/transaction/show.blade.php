<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Detail Transaksi</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $transaction) }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Perhiasan</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($transaction->transactionDetails as $transaction_detail)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $transaction_detail->jewellery->getFirstMediaUrl('image') }}"
                                            alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $transaction_detail->jewellery->name }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ 'Rp. ' . number_format($transaction_detail->jewellery->price, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $transaction_detail->quantity }}
                        </td>
                        <td class="text-center">
                            {{ 'Rp. ' . number_format($transaction_detail->total, 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <th colspan="1" class="font-bold">Total</th>
                    <th colspan="1" class="text-center font-bold">
                        {{ $transaction->transactionDetails()->sum('quantity') }}</th>
                    <td colspan="2" class="text-center font-bold">
                        {{ 'Rp. ' . number_format($transaction->transactionDetails()->sum('total'), 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layouts.admin>
