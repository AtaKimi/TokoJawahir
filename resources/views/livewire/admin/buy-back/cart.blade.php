<div class="pb-16">
    <x-admin.form.search />
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center">Total Pembelian</th>
                    <th class="text-center">Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaction_details as $transaction_detail)
                    <!-- row 1 -->
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $transaction_detail->jewellery->getFirstMediaUrl('image') }}" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $transaction_detail->jewellery->name }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ 'Rp ' . number_format($transaction_detail->jewellery->price, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $transaction_detail->buyBackQuantityLeft() }}
                        </td>

                        <livewire:admin.buy-back.cart-detail :transaction_detail="$transaction_detail" :buy_back="$buy_back" />
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{-- {{ $jewelleries->links('pagination::simple-tailwind') }} --}}
    </div>
    <livewire:admin.buy-back.cart-bubble :buy_back="$buy_back" />
</div>
