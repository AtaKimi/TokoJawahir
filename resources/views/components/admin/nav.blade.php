@props([
    'store' => 'Toko',
])

<nav class="navbar border-b-2 border-gray-300 shadow-md px-6 top-0 lg:z-20 bg-white">
    <div class="flex-none">
        <label for="my-drawer-2" class="btn btn-square btn-ghost drawer-button lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block h-5 w-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
    </div>
    <div class="flex-1">
        <a class="btn btn-ghost text-2xl" href="{{ route('guest.index') }}">
            <span class="fill-black">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="20"
                    viewBox="0 0 24 24" width="20">
                    <rect fill="none" height="24" width="24" />
                    <g>
                        <polygon points="17.77,3.77 16,2 6,12 16,22 17.77,20.23 9.54,12" />
                    </g>
                </svg>
            </span>
            Kembali
        </a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal text-base font-semibold gap-3">
            <li>
                <details>
                    <summary>{{ auth()->user()->name }}</summary>
                    <ul class="bg-white shadow-xl rounded-t-none p-2 z-50">
                        @role('admin')
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('user.profile.index') }}">Profil</a></li>
                        @else
                            <li><a href="{{ route('user.transaction.index') }}">Transaksi</a></li>
                            <li><a href="{{ route('user.buyback.index') }}">Beli Kembali</a></li>
                            <li><a href="{{ route('user.profile.index') }}">Profil</a></li>
                        @endrole
                        <li>
                            <form action="{{ route('logout') }}" method="post">@csrf<button
                                    type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>
</nav>
