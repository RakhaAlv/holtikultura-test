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

            @foreach($rows as $row)

        <tr class="border-b border-[#DCEFD9] bg-[#E9FFE8] transition hover:bg-[#DDF7DB]">

                <!-- Komoditas -->

                <td class="px-8 py-5 text-[16px] font-medium text-[#222]">

                    {{ $row['komoditas'] }}

                </td>

                <!-- Wilayah -->

                <td class="px-6 py-5">

                    <button
                        class="flex items-center gap-3 text-[16px] text-[#222] transition hover:text-green-700">

                        <img
                            src="{{ asset('Icon-Arrow-Right.svg') }}"
                            class="h-4 w-4">

                        {{ $row['wilayah'] }}

                    </button>

                </td>

                <!-- Target --> 
                
                <td class="px-6 py-5 text-[16px]">

                    {{ $row['target'] }}
                
                </td>

                <!-- Realisasi -->

                <td class="px-6 py-5 text-[16px] font-semibold text-[#138A2E]">

                    {{ $row['realisasi'] }}

                </td>

                <!-- Persentase --> 

                <td class="px-6 py-6 text-center">

                    <span class="rounded-lg bg-[#F6C1C1] px-3 py-1 text-[14px] font-medium text-[#9A2323]">

                        {{$row['persentase'] }}

                    </span>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>