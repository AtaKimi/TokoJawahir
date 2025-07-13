<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <x-header.meta />
    <x-header.link />
</head>

<body class="font-sans bg-gray-50">
    <main>
        <x-admin.sidebar :store="$store">
            {{ $slot }}
        </x-admin.sidebar>
    </main>
    @livewireScriptConfig
</body>

</html>
