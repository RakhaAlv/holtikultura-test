<div
    x-data="{ aceh: true }"
    class="overflow-hidden rounded-[14px] bg-white shadow-[0_4px_12px_rgba(0,0,0,0.08)]">
    
    {{-- Header --}}
    <div class="border-b border-[#E5E7EB] px-4 py-3">

        <div class="flex items-start gap-4">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#B8F0C6]">

                <img
                    src="{{ asset('Icon-Tabel.svg') }}"
                    class="h-7 w-7">

            </div>

            <div>

                <h2 class="text-[22px] font-bold text-[#1F2937]">
                    Tabel Capaian Wilayah (Pivot)
                </h2>

                <p class="mt-1 text-[14px] text-[#6B7280]">
                    Klik tanda &gt; untuk melihat rincian hingga tingkat Kelompok Tani.
                    Geser tabel ke kanan atau ke bawah untuk melihat seluruh data.
                </p>

            </div>

        </div>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="min-w-[1405px] border-collapse">

         <thead>

            <tr class="bg-[#F1FFF8]">

                <th
                    rowspan="2"
                    class="w-[260px] border border-[#E5E7EB] px-5 py-6 text-center text-[15px] font-bold text-[#24434D]">

        WILAYAH

        </th>

            <th colspan="3" class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                BAWANG PUTIH
            <span class="text-[12px] text-gray-500">(Ha)</span>

        </th>

            <th colspan="3" class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                BAWANG MERAH
            <span class="text-[12px] text-gray-500">(Ha)</span>

        </th>

            <th colspan="3" class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                CABAI
            <span class="text-[12px] text-gray-500">(Ha)</span>

        </th>

            <th colspan="3" class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                DURIAN
            <span class="text-[12px] text-gray-500">(Ha)</span>

        </th>

            <th colspan="3" class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                P2B 
            <span class="text-[12px] text-gray-500">(Kelompok)</span>

        </th>

    </tr>

    <tr class="bg-white">

    @for($i=0;$i<5;$i++)

        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold">
            Target
        </th>

        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold">
            Realisasi
        </th>

        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold">
            %
        </th>

        @endfor

        </tr>

    </thead>

        <tbody class="text-[13px]">

    {{-- =============================== --}}
    {{-- PROVINSI ACEH --}}
    {{-- =============================== --}}

    <tr
        @click="aceh = !aceh"
        class="cursor-pointer bg-[#F8FBFF] hover:bg-[#EEF6FF] transition">

        {{-- Wilayah --}}
        <td class="border border-[#E5E7EB] px-4 py-3">

            <div class="flex items-center gap-3">

                <svg
                    class="h-4 w-4 transition duration-300"
                    :class="{ 'rotate-90': aceh }"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path d="M9 5l7 7-7 7"/>

                </svg>

                <span class="font-semibold">
                    Prov. Aceh
                </span>

            </div>

        </td>

        {{-- Bawang Putih --}}
        <td class="border text-center">40</td>
        <td class="border text-center">0</td>
        <td class="border text-center">
            <span class="rounded-full bg-red-100 px-2 py-1 text-[11px] font-semibold text-red-600">
                0%
            </span>
        </td>

        {{-- Bawang Merah --}}
        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        {{-- Cabai --}}
        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        {{-- Durian --}}
        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        {{-- P2B --}}
        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

    </tr>

    {{-- =============================== --}}
    {{-- KABUPATEN --}}
    {{-- =============================== --}}

    <tr
        x-show="aceh"
        x-transition>

        <td class="border border-[#E5E7EB] pl-10 py-3">

            Kab. Aceh Tengah

        </td>

        <td class="border text-center">20</td>
        <td class="border text-center">0</td>
        <td class="border text-center">
            <span class="rounded-full bg-red-100 px-2 py-1 text-[11px] font-semibold text-red-600">
                0%
            </span>
        </td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

    </tr>

    <tr
        x-show="aceh"
        x-transition>

        <td class="border border-[#E5E7EB] pl-10 py-3">
            Kab. Gayo Lues
        </td>

        <td class="border text-center">10</td>
        <td class="border text-center">0</td>
        <td class="border text-center">
            <span class="rounded-full bg-red-100 px-2 py-1 text-[11px] font-semibold text-red-600">
                0%
            </span>
        </td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

        <td class="border text-center">0</td>
        <td class="border text-center">0</td>
        <td class="border text-center">-</td>

    </tr>

    </tbody>    

        </table>

    </div>

</div>