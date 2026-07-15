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
        x-show="sidebarOpen"
        x-transition:enter="transition duration-300"
        x-transition:leave="transition duration-300"
        class="shrink-0">

        @include('partials.sidebar')

    </div> {{-- PENUTUP SIDEBAR --}}

    {{-- Content --}}
    <div class="flex flex-1 flex-col">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Isi halaman --}}
        <main class="flex-1 p-5">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>