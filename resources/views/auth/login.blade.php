<x-layouts.auth>
    <div class="h-screen w-screen flex justify-center items-center">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-4 border-4 rounded-2xl border-base-300 p-8 shadow-md">
                <div class="flex justify-center items-center">
                    <p class="text-2xl font-bold">Login</p>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                            fill="undefined">
                            <path
                                d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                        </svg>
                        <input type="text" class="grow" placeholder="Email" id="email" name="email" />
                    </label>
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="input input-bordered flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                            fill="undefined">
                            <path
                                d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z" />
                        </svg>
                        <input type="password" class="grow" value="password" id="password" name="password" />
                    </label>
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full btn btn-primary text-xl tracking-wide">Login</button>
            </div>
        </form>

    </div>
</x-layouts.auth>
