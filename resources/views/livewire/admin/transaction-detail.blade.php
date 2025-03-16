<th class="flex gap-2 items-center">
    <div class="grow">
        <input type="number" placeholder="Type here" class="input w-full max-w-xs" wire:model="count"
            wire:input.debounce.500ms="updateQuantity" />
        @error('count')
            <p class="label-text-alt text-red-700">* {{ $message }}</p>
        @enderror
    </div>
    <div wire:loading wire:target='updateQuantity'>
        <span class="loading loading-spinner loading-md"></span>
    </div>
</th>
