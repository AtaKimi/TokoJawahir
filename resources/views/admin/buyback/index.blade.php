<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">

        <div>
            <x-admin.title>List Beli Kembali</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
        <a href="{{ route('admin.buyback.users') }}" class="btn btn-primary text-lg fill-white">
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
                <tr>
                    <th>Identitas</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi/Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buybacks as $buyback)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $buyback->user->getFirstMediaUrl('image') }}" />
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-50">{{ $buyback->user->phone }}</div>
                                    <div class="font-bold">{{ $buyback->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ 'Rp. ' . number_format($buyback->total, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ $buyback->created_at }}
                        </td>
                        <td>
                            {{-- @if ($transaction->status == App\Enum\TransactionStatus::PENDING->value)
                                <a href="{{ route('admin.transaction.create', [$transaction->user, $transaction]) }}"
                                    class="btn btn-warning w-full">Pending</a>
                            @elseif ($transaction->status == App\Enum\TransactionStatus::SUCCESS->value)
                                <a href="{{ route('admin.transaction.review', [$transaction->user, $transaction]) }}"
                                    class="btn btn-success w-full">Success</a>
                            @else
                                <a href="{{ route('admin.transaction.review', [$transaction->user, $transaction]) }}"
                                    button class="btn btn-error w-full">Failed</a>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-3">
        {{-- {{ $transactions->links('pagination::simple-tailwind') }} --}}
    </div>
</x-layouts.admin>
