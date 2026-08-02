@foreach($kecamatans as $kec)

    <tr
        class="kecamatanRow group-kab-{{ $kabupatenId }} cursor-pointer bg-white hover:bg-[#F7FFF6] transition"
        data-id="{{ $kec['id'] }}"
        data-tahun="{{ $tahun }}">

        <td class="border border-[#E5E7EB] py-2 pl-16">

            <div class="flex items-center gap-3">

                <svg
                    class="chevron h-3.5 w-3.5 transition duration-300"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path d="M9 5l7 7-7 7" />

                </svg>

                <span>Kec. {{ $kec['nama'] }}</span>

            </div>

        </td>

        @foreach([1, 2, 3, 5, 7] as $komId)
            @php $komData = $kec['komoditas'][$komId]; @endphp

            <td class="border text-center text-gray-400">-</td>

            <td class="border text-center">
                {{ $komData['realisasi'] > 0 ? number_format($komData['realisasi'], 0, ',', '.') : '0' }}
            </td>

            <td class="border text-center text-gray-400">-</td>

        @endforeach

    </tr>

@endforeach