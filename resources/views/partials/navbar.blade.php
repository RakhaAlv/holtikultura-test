<nav
    x-data="{ openPeriode: false }"
    class="fixed top-0 right-0 z-30 flex h-[80px] items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm transition-all duration-300"
    :class="sidebarMini ? 'left-[90px]' : 'left-[280px]'">

    <!-- Left -->
    <div class="flex items-center gap-4">

        <!-- Toggle Sidebar -->
        <button
            @click="sidebarMini = !sidebarMini"
            class="rounded-lg p-2 transition hover:bg-gray-100">

            <img
                src="{{ asset('Icon-Sidebar.svg') }}"
                alt="Sidebar"
                class="h-10 w-10">
        </button>

        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-[#1F2937]">
            @yield('navbar-title', 'Dashboard Utama')
        </h1>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-4">

        <!-- Periode -->
        <div class="relative">

            <button
                @click="openPeriode = !openPeriode"
                class="flex h-11 min-w-[190px] items-center justify-between rounded-xl border border-gray-300 bg-white px-4 shadow-sm transition hover:border-green-600">

                <div class="flex items-center gap-2">

                    <img
                        src="{{ asset('Icon-Calender.svg') }}"
                        class="h-4 w-4">

                    <span class="text-sm font-medium text-gray-700">
                    Periode {{ session('tahun', 2025) }}
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

           <!-- Dropdown -->
            <div
                x-show="openPeriode"
                @click.outside="openPeriode = false"
                x-transition
                class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl bg-white shadow-xl">

            <a
                href="{{ url()->current() }}?tahun=2025"
                class="block w-full px-4 py-2.5 text-left text-sm hover:bg-gray-100">

                Periode 2025

            </a>

            <a
                href="{{ url()->current() }}?tahun=2026"
                class="block w-full px-4 py-2.5 text-left text-sm hover:bg-gray-100">

                Periode 2026

            </a>

            </div>

        </div>

        <!-- Update Data -->
        <button
            class="flex h-11 items-center gap-2 rounded-xl bg-[#16B33A] px-5 text-white shadow-md transition hover:bg-[#139630]">

            <img
                src="{{ asset('Icon-UpdateData.svg') }}"
                class="h-4 w-4">

            <span class="text-sm font-semibold">
                Update Data
            </span>

        </button>

    </div>

</nav>
