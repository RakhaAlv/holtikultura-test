<aside
    x-data="{ openProfile: false, openKomoditas: true }"
    :class="sidebarMini ? 'w-[90px]' : 'w-[280px]'"
    class="relative flex h-screen flex-col overflow-hidden bg-[#165C27] text-white transition-all duration-300 ease-in-out">

    <!-- Background -->
    <img
        src="{{ asset('Background-Navigation-Bar.png') }}"
        class="absolute inset-0 h-full w-full object-cover opacity-80 pointer-events-none select-none">

    <!-- Content -->
    <div class="relative z-10 flex h-full flex-col">

        <!-- Logo -->
        <div
            class="flex items-center pt-5 transition-all duration-300"
            :class="sidebarMini ? 'justify-center px-0' : 'gap-4 px-5'">

            <img
                src="{{ asset('logo-kementrian-pertanian.png') }}"
                class="h-10 w-10">

            <h1
                x-show="!sidebarMini"
                x-transition.opacity.duration.200ms
                class="text-[18px] font-bold whitespace-nowrap">
                Ditjen Hortikultura
            </h1>

        </div>

        <hr class="mx-5 mt-5 border-green-700">

        <!-- Dashboard -->
        <div
            class="pt-4 transition-all duration-300"
            :class="sidebarMini ? 'px-2' : 'px-4'">

            <a
                href="#"
                class="flex rounded-xl bg-[#16B33A] py-2.5 shadow-lg transition-all duration-300"
                :class="sidebarMini ? 'justify-center px-0' : 'items-center gap-4 px-3'">

                <img
                    src="{{ asset('Icon-Dashboard.svg') }}"
                    class="h-5 w-5 shrink-0">

                <span
                    x-show="!sidebarMini"
                    x-transition.opacity.duration.200ms
                    class="text-[15px] font-medium whitespace-nowrap">
                    Dashboard Utama
                </span>

            </a>

        </div>

        <hr class="mx-5 mt-4 border-green-700">

        <!-- Rekap Komoditas -->
        <div class="mt-4">

            <button
                    @click="!sidebarMini && (openKomoditas = !openKomoditas)"
                    class="flex w-full transition-all duration-300"
                    :class="sidebarMini
                    ? 'justify-center'
                    : 'items-center justify-between px-6'">

                <span
                    x-show="!sidebarMini"
                    x-transition.opacity
                    class="text-sm font-semibold uppercase tracking-wide">

                    Rekap Data Komoditas

                </span>

                <svg
                    x-show="!sidebarMini"
                    x-transition.opacity
                    class="h-5 w-5 transition"
                    :class="{ 'rotate-180': openKomoditas }"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path d="M19 9l-7 7-7-7"/>

                </svg>

            </button>

            <!-- ========================= -->
            <!-- DROPDOWN NORMAL -->
            <!-- ========================= -->

            <div
                x-show="!sidebarMini && openKomoditas"
                x-transition
                class="mx-4 mt-4 rounded-xl bg-[#083E16] p-4 shadow-xl">

            <a href="#" class="mb-4 flex items-center gap-4 rounded-lg px-2 py-2 hover:bg-[#0E5A22]">
                <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
                <span class="text-[16px]">Bawang Putih</span>
            </a>

            <a href="#" class="mb-4 flex items-center gap-4 rounded-lg px-2 py-2 hover:bg-[#0E5A22]">
                <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
                <span class="text-[16px]">Bawang Merah</span>
            </a>

            <a href="#" class="mb-4 flex items-center gap-4 rounded-lg px-2 py-2 hover:bg-[#0E5A22]">
                <img src="{{ asset('Icon-Cabai.svg') }}" class="w-6">
                <span class="text-[16px]">Cabai</span>
            </a>

    <a href="#" class="mb-5 flex items-center gap-4">
        <img src="{{ asset('Buah-Icon.svg') }}" class="w-6">
        <span class="text-[18px] text-white">Durian</span>
    </a>

            <a href="#" class="flex items-center gap-4 rounded-lg px-2 py-2 hover:bg-[#0E5A22]">
                <img src="{{ asset('Icon-tractor.svg') }}" class="w-6">
                <span class="text-[16px]">P2B</span>
            </a>

    </div>

            <!-- ========================= -->
            <!-- MINI SIDEBAR -->
            <!-- ========================= -->

            <div
                x-show="sidebarMini"
                x-transition
                class="mt-4 flex flex-col items-center gap-3">

            <a href="#" class="flex h-12 w-12 items-center justify-center rounded-xl hover:bg-green-700">
                <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
            </a>

            <a href="#" class="flex h-12 w-12 items-center justify-center rounded-xl hover:bg-green-700">
                <img src="{{ asset('Icon-Bawang.svg') }}" class="w-6">
            </a>

            <a href="#" class="flex h-12 w-12 items-center justify-center rounded-xl hover:bg-green-700">
                <img src="{{ asset('Icon-Cabai.svg') }}" class="w-6">
            </a>

            <a href="#" class="flex h-12 w-12 items-center justify-center rounded-xl hover:bg-green-700">
                <img src="{{ asset('Buah-Icon.svg') }}" class="w-6">
            </a>

            <a href="#" class="flex h-12 w-12 items-center justify-center rounded-xl hover:bg-green-700">
                <img src="{{ asset('Icon-tractor.svg') }}" class="w-6">
            </a>

        </div>

</div>

<hr class="mx-5 mt-4 border-green-700">

            {{-- ========================================== --}}
            {{-- Rekap Data Wilayah --}}
            {{-- ========================================== --}}

        <div
            class="mt-4 transition-all duration-300"
            :class="sidebarMini ? 'px-0 flex justify-center' : 'px-6'">

        <a
            href="#"
            class="flex rounded-xl py-2.5 transition hover:bg-green-800"
            :class="sidebarMini ? 'justify-center w-12 h-12 items-center' : 'items-center gap-4 px-3'">

        <img
            src="{{ asset('Icon-Map.svg') }}"
            class="w-6 shrink-0">

        <span
            x-show="!sidebarMini"
            x-transition.opacity
            class="text-base font-medium uppercase whitespace-nowrap">

            Rekap Data Wilayah

        </span>

    </a>

</div>

            {{-- ========================================== --}}
            {{-- Management Data --}}
            {{-- Super Admin & Admin Direktorat --}}
            {{-- ========================================== --}}

            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminDirektorat())

        <hr class="mx-5 mt-4 border-green-700">

        <div
            class="mt-4 transition-all duration-300"
            :class="sidebarMini ? 'px-0 flex justify-center' : 'px-6'">

        <a
            href="#"
            class="flex rounded-xl py-2.5 transition hover:bg-green-800"
            :class="sidebarMini ? 'justify-center w-12 h-12 items-center' : 'items-center gap-4 px-3'">

        <img
            src="{{ asset('Icon-Management.svg') }}"
            class="w-6 shrink-0">

        <span
            x-show="!sidebarMini"
            x-transition.opacity
            class="text-base font-medium uppercase whitespace-nowrap">

            Management Data

        </span>

    </a>

</div>


@endif

        {{-- ========================================== --}}
        {{-- User Management --}}
        {{-- Super Admin Only --}}
        {{-- ========================================== --}}

        @if(auth()->user()->isSuperAdmin())

        <hr class="mx-5 mt-4 border-green-700">

        <div
            class="mt-4 transition-all duration-300"
            :class="sidebarMini ? 'px-0 flex justify-center' : 'px-6'">

        <a
            href="#"
            class="flex rounded-xl py-2.5 transition hover:bg-green-800"
            :class="sidebarMini ? 'justify-center w-12 h-12 items-center' : 'items-center gap-4 px-3'">

        <img
            src="{{ asset('Icon-Management.svg') }}"
            class="w-6 shrink-0">

        <span
            x-show="!sidebarMini"
            x-transition.opacity
            class="text-base font-medium uppercase whitespace-nowrap">

            User Management

        </span>

    </a>

</div>

@endif

<!-- Spacer -->

<div class="flex-1"></div>

<!-- Profile -->

<div class="relative border-t border-green-700">

    <button
        @click="!sidebarMini && (openProfile = !openProfile)"
        class="flex w-full transition-all duration-300 hover:bg-green-800"
        :class="sidebarMini
            ? 'justify-center items-center py-5'
            : 'items-center justify-between px-5 py-4'">

        <!-- Left -->
        <div
            class="flex items-center"
            :class="sidebarMini ? 'justify-center' : 'gap-4'">

            <img
                src="{{ asset('Icon-User.svg') }}"
                class="h-10 w-10 shrink-0">

            <span
                x-show="!sidebarMini"
                x-transition.opacity.duration.200ms
                class="text-base font-medium whitespace-nowrap">

                {{ auth()->user()->name }}

            </span>

        </div>

        <!-- Arrow -->

        <svg
            x-show="!sidebarMini"
            x-transition.opacity
            class="h-5 w-5 transition duration-300"
            :class="{ 'rotate-180': openProfile }"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 9l-7 7-7-7"/>

        </svg>

    </button>

    <!-- Dropdown -->

    <div
        x-show="!sidebarMini && openProfile"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mx-4 mb-4 rounded-xl bg-[#0B4118] shadow-lg">

        <form
            method="POST"
            action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-4 py-3 transition hover:bg-green-800">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>

                </svg>

                Logout

            </button>

        </form>

    </div>

</div>

</div>

</aside>