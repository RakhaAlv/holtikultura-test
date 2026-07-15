<aside 
    x-data="{ openProfile: false, openKomoditas:true}"
    class="relative felx h-screen w-[310px] flex-col overflow-hidden bg-[#165C27] text-white">

    <!-- Background Daun -->
     <img
        src="{{ asset('Background-Navigation-Bar.png') }}"
        class="absolute inset-0 h-full w-full object-cover opacity-80 pointer-events-none select-none z-0">

    <!-- content -->
     <div class="relative z-10 flex h-full flex-col">

     <!-- Logo -->
        <div class="flex items-center gap-4 px-5 pt-5">

        <img
            src="{{ asset('logo-kementrian-pertanian.png')}}"
            class="h-12 w-12">

        <h1 class="text-[20px] font-bold text-white">
            Ditjen Hortikultura
        </h1>
    
    </div>

    <hr class="mx-5 mt-5 border-green-700">

    <!-- Dashboard -->
     <div class="px-4 pt-4">

        <a 
            href="#"
            class="flex items-center gap-4 rounded-xl bg-[#16B33A] px-4 py-3 shadow-lg">

            <img
                src="{{ asset('Icon-Dashboard.svg') }}"
                class="h-6 w-6">

            <span class="font-medium text-white">
                Dashboard Utama
            </span>
        </a>
</div>

<hr class="mx-5 mt-4 border-green-700">
    <!-- Rekap Komoditas -->

    <div class="mt-6">
        <button
            @click="openKomoditas = !openKomoditas"
            class="flex w-full items-center justify-between px-6">

    <span
        class="text-sm font-semibold uppercase tracking-wide text-white">
        Rekap Data Komoditas
    </span>

    <svg
        class="h-5 w-5 text-white transition"
        :class="{ 'rotate-180': openKomoditas }"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">

        <path d="M19 9l-7 7-7-7"/>

    </svg>

</button>

<!-- Dropdown -->

<div
    x-show="openKomoditas"
    x-transition
    class="mx-4 mt-4 rounded-xl bg-[#083E16] p-4 shadow-xl">

    <a href="#" class="mb-5 flex items-center gap-4">
        <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
        <span class="text-base text-white">Bawang Putih</span>
    </a>

    <a href="#" class="mb-5 flex items-center gap-4">
        <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
        <span class="text-base text-white">Bawang Merah</span>
    </a>

    <a href="#" class="mb-5 flex items-center gap-4">
        <img src="{{ asset('Icon-Cabai.svg') }}" class="w-6">
        <span class="text-base text-white ">Cabai</span>
    </a>

    <a href="#" class="mb-5 flex items-center gap-4">
        <img src="{{ asset('Buah-Icon.svg') }}" class="w-6">
        <span class="text-base text-white">Durian</span>
    </a>

    <a href="#" class="flex items-center gap-4">
        <img src="{{ asset('Icon-tractor.svg') }}" class="w-6">
        <span class="text-base text-white">P2B</span>
    </a>

    </div>

</div>

<hr class="mx-5 mt-4 border-green-700">
<!-- Rekap wilayah -->

<div class="mt-5 px-6">

    <a
        href="#"
        class="flex items-center gap-4">

        <img
            src="{{ asset('Icon-Map.svg') }}"
            class="w-6">

        <span 
            class="text-base font-medium uppercase text-white">
            Rekap Data Wilayah
        </span>
    </a>
</div>

<hr class="mx-5 mt-4 border-green-700">

<div class="mt-5 px-6">
    <a
        href="#"
        class="flex items-center gap-4">

    <img
        src="{{ asset('Icon-Management.svg') }}"
        class="w-6">

    <span class="text-base font-medium uppercase text-white">
        Management Data
    </span>
</a>
</div>

<hr class="mx-5 mt-4 border-green-700">

<!-- User Management -->
 <div class="mt-6 px-6">

    <a
       href="#"
       class="flex items-center gap-4">

    <img
        src="{{ asset('Icon-Management.svg') }}"
        class="w-6">
    
    <span class="text-base font-medium uppercase text-white">
        User Management
    </span>
</a>
</div>



<!-- Spacer -->

<div class="flex-1"></div>

<!-- Profile -->

<div class="relative">

    <button 
        @click="openProfile=!openProfile"
        class="flex w-full items-center justify-between px-5 py-4 hover:bg-green-800">

        <div class="flex items-center gap-4">

            <img
                src="{{ asset('Icon-User.svg') }}"
                class="w-10">

            <span class="text-base font-medium text-white">
                Email
            </span>

        </div>

        <svg
            class="h-6 w-6 text-white transition"
            :class="{ 'rotate-180': openProfile }"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">

            <path d="M19 15l-7 7-7-7"/>
        </svg>

    </button>

    <!-- Dropdown -->

    <div
        x-show="openProfile"
        x-transition
        class="mx-5 mb-5 rounded-xl bg-[#0B4118]">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-4 px-4 py-3 hover:bg-green-800 text-white">
                Logout
            </button>
        </form>
    </div>
</div>
</div>
</aside>


    