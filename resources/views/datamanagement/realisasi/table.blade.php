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
                @forelse($realisasi as $item)

                <tr class="border-b hover:bg-[#FAFAFA]">

                <td class ="px-3 py-3 text-center font-semibold">
                    {{ $loop->iteration + ($realisasi->currentPage() - 1) * $realisasi->perPage() }}
                </td>

            <td class="px-3 py-3">
                {{ $item->kegiatan?->nama_kegiatan }}
            </td>

            <td class="px-3 py-3">
                {{ $item->komoditas?->nama }}
            </td>

            <td class="px-3 py-3">
                {{ $item->nama_kelompok }} 
            </td>

            <td class="px-3 py-3">
                {{ $item->desa?->nama }}
            </td>

            <td class="px-3 py-3">
                {{ $item->kecamatan?->nama }}
            </td>

            <td class="px-3 py-3">
                {{ $item->kabupaten?->nama }}
            </td>
            
            <td class="px-3 py-3">
                {{ $item->provinsi?->nama }}
            </td>

             {{-- Target nanti --}}
    <td class="px-3 py-3 text-center font-semibold text-[#2563EB]">
        -
    </td>

    <td class="px-3 py-3 text-center font-semibold text-[#15803D]">
        {{ number_format($item->jumlah_output,2,',','.') }}
        {{ $item->satuan?->nama }}
    </td>

    <td class="px-3 py-3 text-center">

        <span class="inline-flex rounded-md bg-[#EAF8EC] px-2 py-1 text-[10px] font-semibold text-[#15803D]">

            {{ $item->status }}

        </span>

    </td>

    <td class="px-3 py-3">

        <div class="flex justify-center gap-1.5">

            <button class="flex h-7 w-7 items-center justify-center rounded-md border border-[#16A34A] text-[#16A34A]">

                ✏️

            </button>

            <button class="flex h-7 w-7 items-center justify-center rounded-md border border-[#EF4444] text-[#EF4444]">

                🗑️

            </button>

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="12" class="py-8 text-center text-gray-500">

        Tidak ada data.

    </td>

</tr>

@endforelse

</tbody>



        </table>

    </div>

    {{-- Footer --}}
<div class="flex items-center justify-between border-t px-4 py-3">

    <p class="text-[12px] text-gray-500">
        Menampilkan
        {{ $realisasi->firstItem() ?? 0 }}
        -
        {{ $realisasi->lastItem() ?? 0 }}
        dari
        {{ $realisasi->total() }}
        data
    </p>

    <div>
        {{ $realisasi->links() }}
    </div>

</div>

</div>