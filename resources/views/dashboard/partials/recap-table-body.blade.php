<tbody>
        

        @forelse($rows as $row)

        @php
            $satuan = strtolower($row['komoditas']) == 'p2b'
            ? 'Kelompok'
            : 'Ha';
        @endphp

            <tr
                x-data="{ open:false }"
                class="border-b border-[#DCEFD9] bg-[#E9FFE8]">

                <td colspan="5" class="p-0">

                    <table class="w-full table-fixed">

                        <colgroup>
                            <col class="w-[22%]">
                            <col class="w-[25%]">
                            <col class="w-[18%]">
                            <col class="w-[18%]">
                            <col class="w-[17%]">
                        </colgroup>

                        <tr class="transition hover:bg-[#DDF7DB]">

                            {{-- Komoditas --}}
                            <td class="px-8 py-5 align-middle">

                            {{ $row['komoditas'] }}

                            </td>


                            {{-- Wilayah --}}
                            <td class="px-6 py-5 align-middle">

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

                            <td class="px-6 py-5 text-center align-middle">

                                {{ number_format($row['target'],0,',','.') }}

                                <span class="text-gray-500">
                                    {{ $satuan }}
                                 </span>

                            </td>


                            {{-- Realisasi --}}
                            <td class="px-6 py-5 text-center font-semibold text-[#138A2E] align-middle">

                                {{ number_format($row['realisasi'],0,',','.') }}

                            <span class="text-[#138A2E]">
                                {{ $satuan }}
                            </span>

                                 </td>

                            {{-- Persentase --}}
                            <td class="px-6 py-5 text-center align-middle">

                                 @php
                                    if ($row['progress'] >= 100) {
                                        $badge = 'bg-green-100 text-green-700';
                                    } elseif ($row['progress'] >= 80) {
                                        $badge = 'bg-yellow-100 text-yellow-700';
                                    } else {
                                        $badge = 'bg-red-100 text-red-700';
                                    }
                                @endphp

                                <span class="inline-flex items-center justify-center rounded-lg px-3 py-1 {{ $badge }}">

                                    {{ number_format($row['progress'],2) }}%

                            </span>

                        </td>

                    </tr>
                        <!-- Placeholder -->
                        <tr
                            x-show="open"
                            x-transition>

                        <td colspan="5" class="bg-[#F7FFF6] p-0">

                            <table class="w-full table-fixed">

                                <colgroup>
                                    <col class="w-[22%]">
                                    <col class="w-[25%]">
                                    <col class="w-[18%]">
                                    <col class="w-[18%]">
                                    <col class="w-[17%]">
                                </colgroup>

           @foreach($row['provinsi'] as $provinsi)

                <tbody x-data="{ openProv:false }">

                    <tr class="border-t border-[#DCEFD9]">

                        {{-- Kolom Komoditas (kosong) --}}

                    <td class="px-8 py-4"></td>

                    {{-- Wilayah --}}
                    <td class="px-6 py-4">

                        <button
                            @click="openProv=!openProv"
                            class="flex items-center gap-3">

                        <img
                            src="{{ asset('Icon-Arrow-Right.svg') }}"
                            class="h-3 w-3 transition"
                            :class="{ 'rotate-90': openProv }">

                        <span>
                            {{ $provinsi['provinsi'] }}
                        </span>

                    </button>

                </td>

                {{-- Target --}}
                <td class="px-6 py-4 text-center">

                    {{ number_format($provinsi['target'],0,',','.') }}

                    <span class="text-gray-500">
                        {{ $satuan }}
                    </span>

                </td>

                {{-- Realisasi --}}
                <td class="px-6 py-4 text-center font-semibold text-[#138A2E]">

                    {{ number_format($provinsi['realisasi'],0,',','.') }}

                <span class="text-[#138A2E]">
                    {{ $satuan }}
                </span>

            </td>

            {{-- Persentase --}}
            <td class="px-6 py-4 text-center">

        @php
            if($provinsi['progress'] >= 100){
                $badge = 'bg-green-100 text-green-700';
            }elseif($provinsi['progress'] >= 80){
                $badge = 'bg-yellow-100 text-yellow-700';
            }else{
                $badge = 'bg-red-100 text-red-700';
            }
        @endphp

        <span class="inline-flex items-center justify-center rounded-lg px-3 py-1 {{ $badge }}">

            {{ number_format($provinsi['progress'],2) }}%

        </span>

    </td>

</tr>



<tr
    x-show="openProv"
    x-transition>

    

    <td colspan="5" class="bg-[#FBFFFB] p-0">

        <table class="w-full table-fixed">

            <colgroup>
                <col class="w-[22%]">
                <col class="w-[25%]">
                <col class="w-[18%]">
                <col class="w-[18%]">
                <col class="w-[17%]">
            </colgroup>

           @foreach($provinsi['kabupaten'] as $kabupaten)

            <tr class="border-t border-[#E5F2E4] hover:bg-[#F6FFF5]">

                {{-- Komoditas --}}
            <td class="px-8 py-3"></td>

                {{-- Wilayah --}}
            <td class="px-10 py-3">

            <div class="flex items-center gap-3">

                <span class="h-2 w-2 rounded-full bg-[#949494]"></span>

                <span>
                    {{ $kabupaten['kabupaten'] }}
                </span>

            </div>

        </td>

        {{-- Target --}}
            <td class="px-6 py-3 text-center">

        {{ number_format($kabupaten['target'],0,',','.') }}

            <span class="text-gray-500">
                {{ $satuan }}
            </span>

        </td>

        {{-- Realisasi --}}
            <td class="px-6 py-3 text-center font-semibold text-[#138A2E]">

        {{ number_format($kabupaten['realisasi'],0,',','.') }}

        <span class="text-[#138A2E]">
            {{ $satuan }}
        </span>

    </td>

    {{-- Persentase --}}
    <td class="px-6 py-3 text-center">

        @php
            if($kabupaten['progress'] >= 100){
                $badge = 'bg-green-100 text-green-700';
            }elseif($kabupaten['progress'] >= 80){
                $badge = 'bg-yellow-100 text-yellow-700';
            }else{
                $badge = 'bg-red-100 text-red-700';
            }
        @endphp

        <span class="inline-flex items-center justify-center rounded-lg px-3 py-1 {{ $badge }}">

            {{ number_format($kabupaten['progress'],2) }}%

        </span>

    </td>

</tr>

@endforeach

        </table>

    </td>

</tr>

            @endforeach

        </table>

    </td>

</tr>

                    </table>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5" class="py-10 text-center text-gray-500">

                    Tidak ada data.

                </td>

            </tr>

        @endforelse

        </tbody>