<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="overflow-x-hidden bg-[#F4F4F4] font-['Poppins']">

<div
    x-data="{ sidebarMini: false }"
    class="flex min-h-screen">

    {{-- Sidebar --}}
    <div class="fixed left-0 top-0 z-40">

        @include('partials.sidebar')

    </div>

    {{-- Content --}}
    <div
        class="flex min-w-0 flex-1 flex-col transition-all duration-300 ease-in-out"
        :class="sidebarMini ? 'ml-[90px]' : 'ml-[280px]'">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Main Content --}}
        <main class="flex-1 p-5 pt-[88px]">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>