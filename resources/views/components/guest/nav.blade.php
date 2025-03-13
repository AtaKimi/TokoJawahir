<nav class="navbar border-b border-grey-500 shadow-md mb-4 px-2 md:px-4 lg:px-6">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl">Toko Jawahir</a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal text-base font-semibold gap-3">

            @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            @endguest

            @auth
                <li>
                    <details>
                        <summary>{{ auth()->user()->name }}</summary>
                        <ul class="bg-base-100 rounded-t-none p-2">
                            <li><a>Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">@csrf<button type="submit">Logout</button>
                                </form>
                            </li>

                        </ul>
                    </details>
                </li>
            @endauth
        </ul>
    </div>
</nav>
