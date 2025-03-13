<label class="form-control w-full">
    <div class="label">
      <span class="label-text">{{ $label }}</span>
    </div>
    <input type="file" class="file-input file-input-bordered w-full" name="{{ $name }}" id="{{ $name }}"/>
    <div class="label">
        @error($name)
        <span class="label-text-alt text-red-700">* {{ $message }}</span>
        @enderror
    </div>
  </label>