<div class="overflow-hidden rounded-[14px] bg-white shadow-[0_3px_10px_rgba(0,0,0,0.08)]">

    <div class="overflow-x-auto">

        <table class="min-w-[1250px] w-full">

            {{-- Header --}}
            <thead class="bg-[#F5FFF7]">

                <tr class="border-b border-[#E5E7EB]">

                    <th class="px-3 py-3 text-center text-[12px] font-bold">No</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kegiatan</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Komoditas</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kelompok Tani</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Desa</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kecamatan</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kabupaten</th>

                    <th class="px-3 py-3 text-left text-[12px] font-bold">Provinsi</th>

                    <th class="px-3 py-3 text-center text-[12px] font-bold">Target</th>

                    <th class="px-3 py-3 text-center text-[12px] font-bold">Realisasi</th>

                    <th class="px-3 py-3 text-center text-[12px] font-bold">Status</th>

                    <th class="px-3 py-3 text-center text-[12px] font-bold">Aksi</th>

                </tr>

            </thead>

            <tbody class="text-[12px]">

                @for($i=1;$i<=10;$i++)

                <tr class="border-b hover:bg-[#FAFAFA]">

                    <td class="px-3 py-3 text-center font-semibold">
                        {{ $i }}
                    </td>

                    <td class="px-3 py-3">
                        Peningkatan Produksi
                    </td>

                    <td class="px-3 py-3">
                        🌶 Cabai
                    </td>

                    <td class="px-3 py-3">
                        Curug Petir
                    </td>

                    <td class="px-3 py-3">
                        Bantarsari
                    </td>

                    <td class="px-3 py-3">
                        Rumpin
                    </td>

                    <td class="px-3 py-3">
                        Bogor
                    </td>

                    <td class="px-3 py-3">
                        Jawa Barat
                    </td>

                    <td class="px-3 py-3 text-center font-semibold text-[#2563EB]">
                        15,0 Ha
                    </td>

                    <td class="px-3 py-3 text-center font-semibold text-[#15803D]">
                        15,0 Ha
                    </td>

                    <td class="px-3 py-3 text-center">

                        <span class="inline-flex rounded-md bg-[#EAF8EC] px-2 py-1 text-[10px] font-semibold text-[#15803D]">
                            Bantuan Sudah Diterima
                        </span>

                    </td>

                    <td class="px-3 py-3">

                        <div class="flex justify-center gap-1.5">

                            <button class="flex h-7 w-7 items-center justify-center rounded-md border border-[#16A34A] text-[12px] text-[#16A34A] hover:bg-[#16A34A] hover:text-white">
                                ✏️
                            </button>

                            <button class="flex h-7 w-7 items-center justify-center rounded-md border border-[#EF4444] text-[12px] text-[#EF4444] hover:bg-[#EF4444] hover:text-white">
                                🗑️
                            </button>

                        </div>

                    </td>

                </tr>

                @endfor

            </tbody>

        </table>

    </div>

    {{-- Footer --}}
    <div class="flex items-center justify-between border-t px-4 py-3">

        <p class="text-[12px] text-gray-500">
            Menampilkan 1 - 10 dari 1.000 data
        </p>

        <div class="flex items-center gap-1.5">

            <button class="rounded-md border px-3 py-1.5 text-[12px] hover:bg-gray-100">
                Sebelumnya
            </button>

            <button class="rounded-md bg-[#15803D] px-3 py-1.5 text-[12px] font-semibold text-white">
                1
            </button>

            <button class="rounded-md border px-3 py-1.5 text-[12px] hover:bg-gray-100">
                2
            </button>

            <button class="rounded-md border px-3 py-1.5 text-[12px] hover:bg-gray-100">
                3
            </button>

            <span class="px-1 text-[12px]">...</span>

            <button class="rounded-md border px-3 py-1.5 text-[12px] hover:bg-gray-100">
                Selanjutnya
            </button>

        </div>

    </div>

</div>