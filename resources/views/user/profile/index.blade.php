<x-layouts.admin>
    <div class="w-full flex justify-between gap-2 p-4 items-center">
        <div>
            <x-admin.title>Profile</x-admin.title>
            {{ Breadcrumbs::view('breadcrumbs::tailwind', Route::currentRouteName()) }}
        </div>
    </div>

    <label class="input input-bordered flex items-center gap-2">
        Name
        <input type="text" class="grow" placeholder="Daisy" />
    </label>
    <label class="input input-bordered flex items-center gap-2">
        Email
        <input type="text" class="grow" placeholder="daisy@site.com" />
    </label>
    <label class="input input-bordered flex items-center gap-2">
        phone
        <input type="text" class="grow" placeholder="085327394829" />
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Your bio</span>
            <span class="label-text-alt">Alt label</span>
        </div>
        <textarea class="textarea textarea-bordered h-24" placeholder="Bio"></textarea>
        <div class="label">
            <span class="label-text-alt">Your bio</span>
            <span class="label-text-alt">Alt label</span>
        </div>
    </label>
</x-layouts.admin>
