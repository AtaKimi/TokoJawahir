<nav class="navbar border-b border-grey-500 shadow-md mb-4 px-6">
    <div class="flex-1">
        <a class="text-xl text-slate-600 font-medium tracking-wider">{{ $store->name }}</a>
    </div>
    <div class="flex-none z-50">
        <ul class="menu menu-horizontal text-base font-semibold gap-3">
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endguest

            @auth
                <li>
                    <details class="font-medium tracking-wider text-gray-700">
                        <summary>{{ auth()->user()->name }}</summary>
                        <ul class="bg-white shadow-xl rounded-t-none p-2">
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
            @endauth
        </ul>
    </div>
</nav>
