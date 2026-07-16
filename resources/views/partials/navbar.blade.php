<nav
    x-data="{ openPeriode: false }"
    class="flex items-center justify-between border-b border-gray-200 bg-white px-8 py-5 shadow-sm">

    <!-- Left -->
<div class ="flex items-center gap-5">

    <!-- Toggle Sidebar -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="rounded-lg p-2 transition hover:bg-gray-100">

            <img
                src="{{ asset('Icon-Sidebar.svg')}}"
                alt="Sidebar"
                class="h-9 w-9">
        </button>

    <!-- Page Title --> 
     <h1 class="text-[28px] font-semibold text-gray-800">
        Dashboard Utama
    </h1>
</div>

    <!-- Right --> 
<div class="flex items-center gap-5">

    <!-- Periode -->
<div class="relative">
    
    <button
         @click="openPeriode = !openPeriode"
         class="flex h-[52px] min-w-[220px] items-center justify-between rounded-xl border border-gray-300 bg-white px-5 shadow-sm transition hover:border-green-600">

        <div class ="flex items-center gap-3">

            <img
                src="{{ asset('Icon-Calender.svg')}}"
                class="h-5 w-5">

            <span class="font-medium text-gray-700">
                Periode 2025
            </span>
        </div> 
        
        <svg
            class="h-5 w-5 text-gray-600 transition duration-200"
            :class="{'rotate-180' : openPeriode}"
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

            <button
                class="block w-full px-5 py-3 text-left hover:bg-gray-100">
                Periode 2025
            </button>      
            
            <button
                class="block w-full px-5 py-3 text-left hover:bg-gray-100">
                Periode 2024
            </button>

            <button
                class="block w-full px-5 py-3 text-left hover:bg-gray-100">
                Periode 2023
            </button>

        </div>
</div>

<!-- update data -->
        <button
            class="flex h-[52px] items-center gap-3 rounded-xl bg-[#16B33A] px-6 text-white shadow-md transition hover:bg-[#139630]">

            <img
                src="{{ asset('Icon-UpdateData.svg') }}"
                class="h-5 w-5">

            <span class="font-semibold">
                Update Data
            </span>

        </button>

    </div>

</nav>