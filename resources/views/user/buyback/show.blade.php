<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Detail Beli Kembali</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $buy_back) }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Perhiasan</th>
                    <th class="text-center">Sisa Barang</th>
                    <th class="text-center">Kuantitas Jual kembali</th>
                    <th class="text-center">Total Harga Beli</th>
                    <th class="text-center">Rugi(%)</th>
                    <th class="text-center">Total Penjualan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($buy_back->buyBackDetails as $buy_back_detail)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $buy_back_detail->transactionDetail->jewellery->getFirstMediaUrl('image') }}"
                                            alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $buy_back_detail->transactionDetail->jewellery->name }}
                                    </div>
                                    <div class="text-sm opacity-50">
                                        {{ 'Rp. ' . number_format($buy_back_detail->transactionDetail->total / $buy_back_detail->transactionDetail->quantity, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $buy_back_detail->transactionDetail->quantity_left }}
                        </td>
                        <td class="text-center">
                            {{ $buy_back_detail->quantity }}
                        </td>
                        <td class="text-center">
                            {{ 'Rp. ' . number_format($buy_back_detail->total, 2, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{ $buy_back->buyBackPercentage->percentage }}%
                        </td>
                        <td class="text-center">
                            {{ 'Rp. ' . number_format($buy_back_detail->total - $buy_back_detail->total * ($buy_back->buyBackPercentage->percentage / 100), 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                @endforelse
                @if ($buy_back->total_reduction)
                    <tr>
                        <th colspan="1" class="font-bold">Sub Total</th>
                        <th colspan="1" class="text-center font-bold">
                        </th>
                        <th colspan="1" class="text-center font-bold">
                            {{ $buy_back->buyBackDetails()->sum('quantity') }}</th>
                        </th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->buyBackDetails()->sum('total'), 2, ',', '.') }}
                        </th>
                        </th>
                        <th></th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->buyBackDetails()->sum('total_sold'), 2, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="5" class="font-bold">Total Pengurangan</th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->total_reduction, 2, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="5" class="font-bold">Total</th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->total_sold, 2, ',', '.') }}
                        </th>
                    </tr>
                @else
                    <tr>
                        <th colspan="1" class="font-bold">Total</th>
                        <th colspan="1" class="text-center font-bold">
                        </th>
                        <th colspan="1" class="text-center font-bold">
                            {{ $buy_back->buyBackDetails()->sum('quantity') }}</th>
                        </th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->buyBackDetails()->sum('total'), 2, ',', '.') }}
                        </th>
                        </th>
                        <th></th>
                        <th colspan="1" class="text-center font-bold">
                            {{ 'Rp. ' . number_format($buy_back->buyBackDetails()->sum('total_sold'), 2, ',', '.') }}
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</x-layouts.admin>
