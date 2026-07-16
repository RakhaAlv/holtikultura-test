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

<body class="bg-[#F4F4F4] font-['Poppins']">

<div
    x-data="{ sidebarOpen: true }"
    class="flex min-h-screen">

    {{-- Sidebar --}}
<div
    class="fixed left-0 top-0 z-40 transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    @include('partials.sidebar')

</div> {{-- PENUTUP SIDEBAR --}}

    {{-- Content --}}
    <div
        class="flex flex-1 flex-col transition-all duration-300"
        :class="sidebarOpen ? 'ml-[280px]' : 'ml-0'">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Isi halaman --}}
        <main class="flex-1 p-5 pt-[88px]">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>