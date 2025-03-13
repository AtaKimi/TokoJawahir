<div>
    <x-admin.form.search />
    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center">Stok Tersedia</th>
                    <th class="text-center">Stok Dibeli</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jewelleries as $jewellery)
                    <!-- row 1 -->
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $jewellery->getFirstMediaUrl('image') }}" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $jewellery->name }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ 'Rp ' . number_format($jewellery->price, 2, ',', '.') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $jewellery->quantity }}
                        </td>

                        <livewire:admin.transaction-detail :jewellery="$jewellery" :transaction="$transaction" />
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{ $jewelleries->links('pagination::simple-tailwind') }}
    </div>
    <livewire:admin.transaction-bubble :transaction="$transaction" :user="$user" />
</div>
