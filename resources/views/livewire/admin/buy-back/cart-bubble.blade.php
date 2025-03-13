<a href=""
    class="fixed btn btn-success h-14 btn-wide bottom-3 right-5 ">
    <div class="flex items-center justify-between w-full gap-2">
        <div class="flex flex-col justify-start text-start w-full gap-2 text-white">
            <div class="flex justify-between">
                <span>Jumlah</span> <span>{{ $quantity }} Item</span>
            </div>
            <div class="flex justify-between">
                <span>Total</span> <span>{{ 'Rp. ' . number_format($total, 2, ',', '.') }}</span>
            </div>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="white">
                <path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
            </svg>
        </div>
    </div>
</a>
