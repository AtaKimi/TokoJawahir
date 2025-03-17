<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>List Beli Kembali</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName(), $user) }}
        </div>
        <x-admin.user.bubble img="{{ $user->getFirstMediaUrl('image') }}" name="{{ $user->name }}"
            phone="{{ $user->phone }}" />
    </div>

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
                @foreach ($buy_backs as $buy_back)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="{{ $buy_back->user->getFirstMediaUrl('image') }}" />
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-50">{{ $buy_back->user->phone }}</div>
                                    <div class="font-bold">{{ $buy_back->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ 'Rp. ' . number_format($buy_back->total, 2, ',', '.') }}
                        </td>
                        <td>
                            {{ $buy_back->created_at }}
                        </td>
                        <td>
                            @if ($buy_back->status == App\Enum\BuyBackStatus::PENDING->value)
                                <a href="{{ route('admin.buyback.create', [$buy_back->user]) }}"
                                    class="btn btn-warning w-full">Pending</a>
                            @elseif ($buy_back->status == App\Enum\BuyBackStatus::SUCCESS->value)
                                <a href="{{ route('admin.buyback.review', [$buy_back->user, $buy_back]) }}"
                                    class="btn btn-success w-full">Success</a>
                            @else
                                <a href="{{ route('admin.buyback.review', [$buy_back->user, $buy_back]) }}" button
                                    class="btn btn-error w-full">Failed</a>
                            @endif
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
