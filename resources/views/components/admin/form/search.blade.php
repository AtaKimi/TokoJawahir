<div class="flex flex-wrap gap-2 @if (request('search')) justify-between @else justify-center md:justify-end @endif  my-2 px-4">
    @if (!request('search'))
        <form action="" method="get">
            <label class="input input-bordered flex items-center gap-2 w-full md:max-w-md">
                <input type="text" class="grow" placeholder="Search" name="search" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="h-4 w-4 opacity-70">
                    <path fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                </svg>
            </label>
        </form>
    @else
        <div class="flex items-center gap-4">
            <div>
                <p>Hasil pencarian untuk "{{ request('search') }}"</p>
            </div>
        </div>
        <form action="" method="get">
            <label class="input input-bordered flex items-center gap-2 w-full md:max-w-md">
                <input type="text" class="grow" placeholder="Search" name="search" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="h-4 w-4 opacity-70">
                    <path fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                </svg>
                <a href="{{request()->url()}}" class="btn btn-ghost btn-square btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="undefined">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg>
                </a>
            </label>
        </form>
    @endif
</div>
