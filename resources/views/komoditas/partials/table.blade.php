<div
    x-data="{ aceh: true }"
    class="rounded-[18px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.08)]">

{{-- Header --}}
<div class="border-b border-[#ECECEC] px-6 py-5">

    <div class="flex items-start gap-4">

        {{-- Icon --}}
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#B8F0C6]">

            <img
                src="{{ asset('Icon-Tabel-Komoditas.svg') }}"
                class="h-7 w-7">

        </div>

        {{-- Title --}}
        <div>

            <h2 class="text-[22px] font-bold text-[#1F2937]">
                Tabel Capaian Wilayah (Pivot)
            </h2>

            <p class="mt-1 text-[14px] text-[#6B7280]">
                Klik tanda <span class="font-semibold">&gt;</span> untuk melihat rincian hingga tingkat Kelompok Tani.
                Geser tabel ke kanan atau ke bawah untuk melihat seluruh data.
            </p>

        </div>

    </div>

</div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F9FB]">

                <tr>

                    <th class="px-6 py-4 text-left text-[15px] font-semibold text-[#60708A]">
                        WILAYAH
                    </th>

                    <th class="px-5 py-4 text-center text-[15px] font-semibold text-[#60708A]">
                        TARGET
                    </th>

                    <th class="px-5 py-4 text-center text-[15px] font-semibold text-[#60708A]">
                        REALISASI
                    </th>

                    <th class="px-5 py-4 text-center text-[15px] font-semibold text-[#60708A]">
                        PERSENTASE
                    </th>

                </tr>

            </thead>

            <tbody>

                {{-- ========================= --}}
                {{-- PROVINSI --}}
                {{-- ========================= --}}

                <tr
                    @click="aceh=!aceh"
                    class="cursor-pointer border-b bg-[#EEF3FF] transition hover:bg-[#E6EEFF]">

                    <td class="px-6 py-4">

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

                            <span class="text-[16px] font-semibold">
                                Prov. Aceh
                            </span>

                        </div>

                    </td>

                    <td class="text-center text-[15px]">
                        40 Ha
                    </td>

                    <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-3 py-1 text-[14px] font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                {{-- ========================= --}}
                {{-- KABUPATEN --}}
                {{-- ========================= --}}

                <tr
                    x-show="aceh"
                    x-transition
                    class="border-b">

                    <td class="py-4 pl-16 text-[15px]">
                        Kab. Aceh Tengah
                    </td>

                    <td class="text-center text-[15px]">
                        20 Ha
                    </td>

                    <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-3 py-1 text-[14px] font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                <tr
                    x-show="aceh"
                    x-transition
                    class="border-b">

                    <td class="py-4 pl-16 text-[15px]">
                        Kab. Gayo Lues
                    </td>

                    <td class="text-center text-[15px]">
                        10 Ha
                    </td>

                    <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-3 py-1 text-[14px] font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                <tr
                    x-show="aceh"
                    x-transition
                    class="border-b">

                    <td class="py-4 pl-16 text-[15px]">
                        Kab. Bener Meriah
                    </td>

                    <td class="text-center text-[15px]">
                        10 Ha
                    </td>

                    <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-3 py-1 text-[14px] font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                {{-- Placeholder Provinsi Lain --}}

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-6 py-4">

                        <div class="flex items-center gap-3">

                            <svg
                                class="h-4 w-4 text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M9 5l7 7-7 7"/>

                            </svg>

                            <span class="text-[16px] font-semibold">
                                Prov. Sumatera Utara
                            </span>

                        </div>

                    </td>

                    <td class="text-center text-[15px]">
                        525 Ha
                    </td>

                    <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-3 py-1 text-[14px] font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>