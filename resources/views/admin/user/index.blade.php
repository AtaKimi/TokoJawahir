<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
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
                    <th>Identitas</th>
                    <th>Total Transaksi</th>
                    <th>Total Jual Beli</th>
                    <th></th>
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
                                <div>
                                    <div class="text-sm opacity-50">{{ $user->phone }}</div>
                                    <div class="font-bold">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.user.transactions', $user) }}"
                                class="btn btn-outline w-full">Total: {{ count($user->transactions) }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.user.buybacks', $user) }}" class="btn btn-outline w-full">Total:
                                {{ count($user->buyBacks) }}</a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
