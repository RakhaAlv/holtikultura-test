@php

$rows = [

[
    'komoditas' => 'Bawang Putih',
    'wilayah' => 'Nasional',
    'target' => '5.000 Ha',
    'realisasi' => '683 Ha',
    'persentase' => '13.7%',
],

[
    'komoditas' => 'Bawang Merah',
    'wilayah' => 'Nasional',
    'target' => '150 Ha',
    'realisasi' => '0 Ha',
    'persentase' => '0.0%',
],

[
    'komoditas' => 'Cabai',
    'wilayah' => 'Nasional',
    'target' => '2.953 Ha',
    'realisasi' => '278 Ha',
    'persentase' => '9.4%',
],

[
    'komoditas' => 'Durian',
    'wilayah' => 'Nasional',
    'target' => '2.337 Ha',
    'realisasi' => '0 Ha',
    'persentase' => '0.0%',
],

[
    'komoditas' => 'P2B',
    'wilayah' => 'Nasional',
    'target' => '411 Kelompok',
    'realisasi' => '156 Kelompok',
    'persentase' => '38%',
],

];

@endphp



<div class="overflow-hidden rounded-[24px] bg-white">

    <!-- Header -->
    <div class="px-1 pt-1">

        <h2 class="text-[28px] font-semibold text-[#222]">
            Rekapitulasi Capaian Kegiatan Hortikultura
        </h2>

        <p class="mt-2 text-[15px] text-gray-500">
            Klik baris berikon panah untuk melihat rincian hingga tingkat kelompok tani.
        </p>

    </div>


<!-- Table -->

<table class ="w-full border-collapse">

    <!-- Header -->

    <thead>

        <tr class ="bg-[#ECECEC] text-left text-[15px] font-semibold uppercase text-[#333]">

            <th class="px-8 py-5">
                    Komoditas
                </th>

                <th class="px-6 py-5">
                    Wilayah
                </th>

                <th class="px-6 py-5">
                    Target
                </th>

                <th class="px-6 py-5">
                    Realisasi
                </th>

                <th class="px-6 py-5 text-center">
                    Persentase
                </th>

            </tr>

 </thead>

        <!-- Body -->

        <tbody>

@foreach($rows as $index => $row)

<tr
    x-data="{ open:false }"
    class="border-b border-[#DCEFD9] bg-[#E9FFE8]">

    <td colspan="5" class="p-0">

        <!-- BARIS NASIONAL -->
        <table class="w-full">

            <tr class="transition hover:bg-[#DDF7DB]">

                <td class="px-8 py-5 w-[22%]">

                    {{ $row['komoditas'] }}

                </td>

                <td class="px-6 py-5 w-[25%]">

                    <button
                        @click="open=!open"
                        class="flex items-center gap-3">

                        <img
                            src="{{ asset('Icon-Arrow-Right.svg') }}"
                            class="h-4 w-4 transition duration-300"
                            :class="{ 'rotate-90': open }">

                        <span>Nasional</span>

                    </button>

                </td>

                <td class="px-6 py-5 w-[18%]">
                    {{ $row['target'] }}
                </td>

                <td class="px-6 py-5 w-[18%] text-[#138A2E] font-semibold">
                    {{ $row['realisasi'] }}
                </td>

                <td class="px-6 py-5 text-center">

                    <span class="rounded-lg bg-[#F6C1C1] px-3 py-1 text-[#9A2323]">

                        {{ $row['persentase'] }}

                    </span>

                </td>

            </tr>

            <!-- DROPDOWN -->
            <tr
                x-show="open"
                x-transition>

                <td colspan="5" class="bg-[#F7FFF6] p-0">

                    <table class="w-full">

                        <!-- ACEH -->

                        <tr class="border-t">

                            <td class="px-20 py-4 w-[22%] text-gray-600">

                                

                            </td>

                            <td class="px-6 py-4 w-[25%]">

                                <button
                                    class="flex items-center gap-3">

                                    <img
                                        src="{{ asset('Icon-Arrow-Right.svg') }}"
                                        class="h-3 w-3">

                                    Aceh

                                </button>

                            </td>

                            <td class="px-6 py-4">
                                600 Ha
                            </td>

                            <td class="px-6 py-4 text-[#138A2E]">
                                350 Ha
                            </td>

                            <td class="px-6 py-4 text-center">

                                <span class="rounded-lg bg-green-100 px-3 py-1 text-green-700">

                                    58%

                                </span>

                            </td>

                        </tr>

                        <!-- SUMUT -->

                        <tr class="border-t">

                            <td class="px-20 py-4">

                                

                            </td>

                            <td class="px-6 py-4">

                                <button
                                    class="flex items-center gap-3">

                                    <img
                                        src="{{ asset('Icon-Arrow-Right.svg') }}"
                                        class="h-3 w-3">

                                    Sumatera Utara

                                </button>

                            </td>

                            <td class="px-6 py-4">
                                480 Ha
                            </td>

                            <td class="px-6 py-4 text-[#138A2E]">
                                215 Ha
                            </td>

                            <td class="px-6 py-4 text-center">

                                <span class="rounded-lg bg-yellow-100 px-3 py-1 text-yellow-700">

                                    44%

                                </span>

                            </td>

                        </tr>

                        <!-- JAWA BARAT -->

                        <tr class="border-t">

                            <td class="px-20 py-4">

                                

                            </td>

                            <td class="px-6 py-4">

                                <button
                                    class="flex items-center gap-3">

                                    <img
                                        src="{{ asset('Icon-Arrow-Right.svg') }}"
                                        class="h-3 w-3">

                                    Jawa Barat

                                </button>

                            </td>

                            <td class="px-6 py-4">
                                800 Ha
                            </td>

                            <td class="px-6 py-4 text-[#138A2E]">
                                118 Ha
                            </td>

                            <td class="px-6 py-4 text-center">

                                <span class="rounded-lg bg-red-100 px-3 py-1 text-red-700">

                                    15%

                                </span>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

    </td>

</tr>

    @endforeach

    </tbody>

</table>

</div>