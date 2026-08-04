<nav
    x-data="{
        openPeriode: false,
        openStatus: false
    }"
    class="fixed top-0 right-0 left-[280px] z-30 flex h-[80px] items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm transition-[left] duration-300"
    :class="sidebarMini ? '!left-[90px]' : '!left-[280px]'">

    <!-- Left -->
    <div class="flex items-center gap-4">

        <!-- Sidebar Toggle -->
        <button
            @click="sidebarMini = !sidebarMini"
            type="button"
            class="rounded-lg p-2 transition hover:bg-gray-100">

            <img
                src="{{ asset('Icon-Sidebar.svg') }}"
                alt="Sidebar Toggle"
                class="h-10 w-10">

        </button>

        <!-- Page Title -->
            <div class="flex flex-col">

                <h1 class="text-3xl font-semibold leading-tight text-[#1F2937]">
                    @if(request()->routeIs('users.*'))
                        User Management
                    @else
                        @yield('navbar-title', 'Dashboard Utama')
                    @endif
                </h1>

            @if(request()->routeIs('dashboard'))
                <span class="mt-1 text-[12px] font-medium text-[#6B7280]">
                    Last updated data:
                <span class="font-semibold text-[#16B33A]">
                    04 Agustus 2026 • 08:30 WIB
                </span>
        </span>
    @endif

    </div>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-4">

        @if(!request()->routeIs('users.*') && !request()->routeIs('data-management'))

            <!-- ========================= -->
            <!-- Periode -->
            <!-- ========================= -->

            <div class="relative">

                <button
                    @click="openPeriode = !openPeriode"
                    type="button"
                    class="flex h-11 min-w-[190px] items-center justify-between rounded-xl border border-gray-300 bg-white px-4 shadow-sm transition hover:border-green-600">

                    <div class="flex items-center gap-2">

                        <img
                            src="{{ asset('Icon-Calender.svg') }}"
                            class="h-4 w-4"
                            alt="Calendar">

                        <span class="text-sm font-medium text-gray-700">
                            Periode {{ session('tahun', 2026) }}
                        </span>

                    </div>

                    <svg
                        class="h-4 w-4 text-gray-600 transition duration-200"
                        :class="{ 'rotate-180': openPeriode }"
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

                <!-- Dropdown Periode -->
                <div
                    x-show="openPeriode"
                    @click.outside="openPeriode = false"
                    x-cloak
                    x-transition
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-100 bg-white shadow-xl">

                    <a
                        href="{{ request()->fullUrlWithQuery(['tahun' => 2025]) }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100">

                        Periode 2025

                    </a>

                    <a
                        href="{{ request()->fullUrlWithQuery(['tahun' => 2026]) }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100">

                        Periode 2026

                    </a>

                </div>

            </div>

            <!-- ========================= -->
            <!-- Status -->
            <!-- ========================= -->

            <div class="relative">

                <button
                    @click="openStatus = !openStatus"
                    type="button"
                    class="flex h-11 min-w-[230px] items-center justify-between rounded-xl border border-gray-300 bg-white px-4 shadow-sm transition hover:border-green-600">


                    <div class="flex items-center gap-2">

                        <img
                            src="{{ asset('Icon-Stats-Navbar.svg') }}"
                            class="h-4 w-4"
                            alt="Status">

                        <span class="text-sm font-medium text-gray-700">
                        Status
                        </span>

                    </div>

                    <svg
                        class="h-4 w-4 text-gray-600 transition duration-200"
                        :class="{ 'rotate-180': openStatus }"
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

                <!-- Dropdown Status -->
                <div
                    x-show="openStatus"
                    @click.outside="openStatus = false"
                    x-cloak
                    x-transition
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-100 bg-white shadow-xl">

                    <a
                        href="#"
                        class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100">

                        Bantuan Sudah Diterima

                    </a>

                    <a
                        href="#"
                        class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100">

                        Bantuan Dalam Proses

                    </a>

                </div>

            </div>

            <!-- ========================= -->
            <!-- Update Data -->
            <!-- Jika kedepannya bakal dipake -->

         <!--  <button
                type="button"
                class="flex h-11 items-center gap-2 rounded-xl bg-[#16B33A] px-5 text-white shadow-md transition hover:bg-[#139630]">

                <img
                    src="{{ asset('Icon-UpdateData.svg') }}"
                    class="h-4 w-4"
                    alt="Update">

                <span class="text-sm font-semibold">
                    Update Data
                </span>

            </button> -->

        @endif

    </div>

</nav>