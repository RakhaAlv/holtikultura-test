<div
    x-data="{ aceh: true }"
    class="rounded-[24px] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

    {{-- Header --}}
    <div class="border-b border-[#ECECEC] px-8 py-6">

        <h2 class="text-[30px] font-semibold text-[#1F2937]">
            Rincian Capaian
        </h2>

        <p class="mt-2 text-[16px] text-[#7A7A7A]">
            Klik baris wilayah untuk melihat detail ke bawah.
        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F9FB]">

                <tr>

                    <th class="px-8 py-5 text-left text-[16px] font-semibold text-[#60708A]">
                        WILAYAH
                    </th>

                    <th class="px-6 py-5 text-center text-[16px] font-semibold text-[#60708A]">
                        TARGET
                    </th>

                    <th class="px-6 py-5 text-center text-[16px] font-semibold text-[#60708A]">
                        REALISASI
                    </th>

                    <th class="px-6 py-5 text-center text-[16px] font-semibold text-[#60708A]">
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
                    class="cursor-pointer border-b bg-[#EEF3FF] hover:bg-[#E6EEFF]">

                    <td class="px-8 py-5">

                        <div class="flex items-center gap-4">

                            <svg
                                class="h-5 w-5 transition duration-300"
                                :class="{ 'rotate-90': aceh }"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M9 5l7 7-7 7"/>

                            </svg>

                            <span class="text-[18px] font-semibold">
                                Prov. Aceh
                            </span>

                        </div>

                    </td>

                    <td class="text-center text-[17px]">
                        40 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
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

                    <td class="py-5 pl-20">
                        Kab. Aceh Tengah
                    </td>

                    <td class="text-center">
                        20 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                <tr
                    x-show="aceh"
                    x-transition
                    class="border-b">

                    <td class="py-5 pl-20">
                        Kab. Gayo Lues
                    </td>

                    <td class="text-center">
                        10 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                <tr
                    x-show="aceh"
                    x-transition
                    class="border-b">

                    <td class="py-5 pl-20">
                        Kab. Bener Meriah
                    </td>

                    <td class="text-center">
                        10 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                {{-- Contoh provinsi kedua --}}

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-8 py-5">

                        <div class="flex items-center gap-4">

                            <svg
                                class="h-5 w-5 text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M9 5l7 7-7 7"/>

                            </svg>

                            <span class="text-[18px] font-semibold">
                                Prov. Sumatera Utara
                            </span>

                        </div>

                    </td>

                    <td class="text-center">
                        525 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-8 py-5">

                        <div class="flex items-center gap-4">

                            <svg
                                class="h-5 w-5 text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M9 5l7 7-7 7"/>

                            </svg>

                            <span class="text-[18px] font-semibold">
                                Prov. Sumatera Barat
                            </span>

                        </div>

                    </td>

                    <td class="text-center">
                        170 Ha
                    </td>

                    <td class="text-center font-semibold text-[#00A63E]">
                        0 Ha
                    </td>

                    <td class="text-center">

                        <span class="rounded-full bg-[#FFE3E3] px-4 py-2 font-semibold text-[#D93025]">
                            0.0%
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>