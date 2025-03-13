@props(['name', 'label', 'placeholder', 'type' => 'text', 'value' => null])

<label class="form-control w-full">
    <div class="label">
        <span class="label-text">{{ $label }}</span>
    </div>
    <input type="{{ $type }}" placeholder="{{ $placeholder }}" class="input input-bordered w-full"
        name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" />
    <div class="label">
        @error($name)
            <span class="label-text-alt text-red-700">* {{ $message }}</span>
        @enderror
    </div>
</label>
