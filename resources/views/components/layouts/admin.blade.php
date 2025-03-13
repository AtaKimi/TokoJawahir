<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-header.meta />
    <x-header.link />
</head>

<body class="font-sans bg-gray-50 text-black min-h-screen">
    <main>
        <x-admin.sidebar>
            {{ $slot }}
        </x-admin.sidebar>
    </main>
    @livewireScriptConfig 
</body>

</html>
