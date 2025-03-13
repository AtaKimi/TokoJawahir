@props(['name', 'label', 'placeholder', 'value' => null])

<label class="form-control">
    <div class="label">
        <span class="label-text">{{ $label }}</span>
    </div>
    <textarea class="textarea textarea-bordered h-24" placeholder="{{ $placeholder }}" name="{{ $name }}" id="{{ $name }}">
        {{ $value }}
    </textarea>
    <div class="label">
        @error($name)
            <span class="label-text-alt text-red-700">* {{ $message }}</span>
        @enderror
    </div>
</label>
