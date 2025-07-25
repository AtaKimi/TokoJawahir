<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-header.meta />
    <x-header.link />
</head>

<body class="font-sans bg-gray-50 min-h-screen">
    <x-guest.nav :store="$store" />

    <div class="p-2 md:p-3 xl:p-4">
        {{ $slot }}
    </div>
</body>

</html>
