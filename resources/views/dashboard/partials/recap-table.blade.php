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

    <!-- Filter -->
    <form method="GET" action="{{ url()->current() }}" class="mt-6 mb-6 flex flex-wrap gap-3">

        <input type="hidden" name="tahun" value="{{ $tahun }}">

        <!-- Provinsi -->
        <select
            name="provinsi"
            class="rounded-lg border border-gray-300 px-3 py-2">

            <option value="">
                Semua Provinsi
            </option>

            @foreach($provinsis as $provinsi)

                <option
                    value="{{ $provinsi->id }}"
                    {{ $provinsiId == $provinsi->id ? 'selected' : '' }}>

                    {{ $provinsi->nama }}

                </option>

            @endforeach

        </select>

        <!-- Kabupaten -->
        <select
            name="kabupaten"
            class="rounded-lg border border-gray-300 px-3 py-2">

            <option value="">
                Semua Kabupaten
            </option>

            @foreach($kabupatens as $kabupaten)

                <option
                    value="{{ $kabupaten->id }}"
                    {{ $kabupatenId == $kabupaten->id ? 'selected' : '' }}>

                    {{ $kabupaten->nama }}

                </option>

            @endforeach

        </select>

        <button
            type="submit"
            class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">

            Terapkan

        </button>

    </form>

    <!-- Table -->

    <table class="w-full border-collapse">

        <thead>

            <tr class="bg-[#ECECEC] text-left text-[15px] font-semibold uppercase text-[#333]">

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

        <tbody>

        @forelse($rows as $row)

            <tr
                x-data="{ open:false }"
                class="border-b border-[#DCEFD9] bg-[#E9FFE8]">

                <td colspan="5" class="p-0">

                    <table class="w-full">

                        <tr class="transition hover:bg-[#DDF7DB]">

                            <td class="w-[22%] px-8 py-5">

                                {{ $row['komoditas'] }}

                            </td>

                            <td class="w-[25%] px-6 py-5">

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

                            <td class="w-[18%] px-6 py-5">

                                {{ number_format($row['target'],0,',','.') }}

                            </td>

                            <td class="w-[18%] px-6 py-5 font-semibold text-[#138A2E]">

                                {{ number_format($row['realisasi'],0,',','.') }}

                            </td>

                            <td class="px-6 py-5 text-center">

                                @php

                                    if ($row['progress'] >= 100) {
                                        $badge = 'bg-green-100 text-green-700';
                                    } elseif ($row['progress'] >= 80) {
                                        $badge = 'bg-yellow-100 text-yellow-700';
                                    } else {
                                        $badge = 'bg-red-100 text-red-700';
                                    }

                                @endphp

                                <span class="rounded-lg px-3 py-1 {{ $badge }}">

                                    {{ number_format($row['progress'],2) }}%

                                </span>

                            </td>

                        </tr>

                        <!-- Placeholder -->
                        <tr
    x-show="open"
    x-transition>

    <td colspan="5" class="bg-[#F7FFF6] p-0">

        <table class="w-full">

            @foreach($row['provinsi'] as $provinsi)

            <tbody x-data="{ openProv:false }">

            <tr class="border-t border-[#DCEFD9]">

                <td class="w-[22%] px-8 py-4"></td>

                <td class="w-[25%] px-6 py-4">

                    <button
    @click="openProv=!openProv"
    class="flex items-center gap-3">

    <img
        src="{{ asset('Icon-Arrow-Right.svg') }}"
        class="h-3 w-3 transition"
        :class="{ 'rotate-90': openProv }">

    {{ $provinsi['provinsi'] }}

</button>

                </td>

                <td class="w-[18%] px-6 py-4">

                    {{ number_format($provinsi['target'],0,',','.') }}

                </td>

                <td class="w-[18%] px-6 py-4 font-semibold text-[#138A2E]">

                    {{ number_format($provinsi['realisasi'],0,',','.') }}

                </td>

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

                    <span class="rounded-lg px-3 py-1 {{ $badge }}">

                        {{ number_format($provinsi['progress'],2) }}%

                    </span>

                </td>
</tr>



<tr
    x-show="openProv"
    x-transition>

    

    <td colspan="5" class="bg-[#FBFFFB] p-0">

        <table class="w-full">

            @foreach($provinsi['kabupaten'] as $kabupaten)

            <tr class="border-t border-[#E5F2E4]">

                <td class="w-[22%] px-24 py-3"></td>

                <td class="w-[25%] px-10 py-3">

                    <div class="flex items-center gap-3">

                        <img
                            src="{{ asset('Icon-Arrow-Right.svg') }}"
                            class="h-3 w-3">

                        {{ $kabupaten['kabupaten'] }}

                    </div>

                </td>

                <td class="w-[18%] px-6 py-3">

                    {{ number_format($kabupaten['target'],0,',','.') }}

                </td>

                <td class="w-[18%] px-6 py-3 font-semibold text-[#138A2E]">

                    {{ number_format($kabupaten['realisasi'],0,',','.') }}

                </td>

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

                    <span class="rounded-lg px-3 py-1 {{ $badge }}">

                        {{ number_format($kabupaten['progress'],2) }}%

                    </span>

                </tr>

            </tbody>

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

    </table>

</div>