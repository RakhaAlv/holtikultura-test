@foreach($desas as $desa)

    <tr class="group-kec-{{ $kecamatanId }} bg-[#FBFFFB]">

        <td class="border border-[#E5E7EB] py-2 pl-24">

            <div class="flex items-center gap-3">

                <span class="h-1.5 w-1.5 rounded-full bg-[#949494]"></span>

                <span>Desa {{ $desa['nama'] }}</span>

            </div>

        </td>

        @foreach([1, 2, 3, 5, 7] as $komId)
            @php $komData = $desa['komoditas'][$komId]; @endphp

            <td class="border text-center text-gray-400">-</td>

            <td class="border text-center">
                {{ $komData['realisasi'] > 0 ? number_format($komData['realisasi'], 0, ',', '.') : '0' }}
            </td>

            <td class="border text-center text-gray-400">-</td>

        @endforeach

    </tr>

@endforeach