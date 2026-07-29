<div
    x-data="{
        openRows: {
            @if($provinsiId)
                '{{ $provinsiId }}': true
            @endif
        }
    }"
    class="overflow-hidden rounded-[14px] bg-white shadow-[0_4px_12px_rgba(0,0,0,0.08)]">

    {{-- ========================= --}}
    {{-- HEADER --}}
    {{-- ========================= --}}
    <div class="border-b border-[#E5E7EB] px-4 py-3">

        <div class="flex items-start gap-4">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#B8F0C6]">

                <img
                    src="{{ asset('Icon-Tabel-Komoditas.svg') }}"
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

    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <div class="overflow-x-auto">

        <table class="min-w-[1405px] border-collapse">

            <thead>

                {{-- Header Komoditas --}}
                <tr class="bg-[#F1FFF8]">

                    <th
                        rowspan="2"
                        class="w-[260px] border border-[#E5E7EB] px-5 py-6 text-center text-[15px] font-bold text-[#24434D]">

                        WILAYAH

                    </th>

                    <th colspan="3"
                        class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                        BAWANG PUTIH
                        <span class="text-[12px] text-gray-500">(Ha)</span>

                    </th>

                    <th colspan="3"
                        class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                        BAWANG MERAH
                        <span class="text-[12px] text-gray-500">(Ha)</span>

                    </th>

                    <th colspan="3"
                        class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                        CABAI
                        <span class="text-[12px] text-gray-500">(Ha)</span>

                    </th>

                    <th colspan="3"
                        class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                        DURIAN
                        <span class="text-[12px] text-gray-500">(Ha)</span>

                    </th>

                    <th colspan="3"
                        class="border border-[#E5E7EB] py-3 text-center text-[15px] font-bold">

                        P2B
                        <span class="text-[12px] text-gray-500">(Kelompok)</span>

                    </th>

                </tr>

                {{-- Sub Header --}}
                <tr class="bg-white">

                    @for ($i = 0; $i < 5; $i++)

                        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold text-center">
                            Target
                        </th>

                        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold text-center">
                            Realisasi
                        </th>

                        <th class="border border-[#E5E7EB] py-3 text-[13px] font-semibold text-center">
                            %
                        </th>

                    @endfor

                </tr>

            </thead>

            <tbody class="text-[13px]">

            @foreach($wilayahRows as $prov)
                {{-- Provinsi Row --}}
                <tr
                    @click="openRows[{{ $prov['id'] }}] = !openRows[{{ $prov['id'] }}]"
                    class="cursor-pointer bg-[#F8FBFF] hover:bg-[#EEF6FF] transition">

                    {{-- Wilayah --}}
                    <td class="border border-[#E5E7EB] px-4 py-3">

                        <div class="flex items-center gap-3">

                            <svg
                                class="h-4 w-4 transition duration-300"
                                :class="{ 'rotate-90': openRows[{{ $prov['id'] }}] }"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M9 5l7 7-7 7" />

                            </svg>

                            <span class="font-semibold text-[13px]">
                                Prov. {{ $prov['nama'] }}
                            </span>

                        </div>

                    </td>

                    {{-- 5 Komoditas --}}
                    @foreach([1, 2, 3, 5, 7] as $komId)
                        @php
                            $komData = $prov['komoditas'][$komId];
                        @endphp
                        <td class="border text-center">
                            {{ $komData['target'] > 0 ? number_format($komData['target'], 0, ',', '.') : '0' }}
                        </td>
                        <td class="border text-center">
                            {{ $komData['realisasi'] > 0 ? number_format($komData['realisasi'], 0, ',', '.') : '0' }}
                        </td>
                        <td class="border text-center">
                            @if($komData['target'] > 0)
                                @php
                                    $progressRound = round($komData['progress']);
                                @endphp
                                @if($progressRound <= 50)
                                    <span class="rounded-full bg-red-100 px-2 py-1 text-[11px] font-semibold text-red-600">
                                        {{ $progressRound }}%
                                    </span>
                                @elseif($progressRound <= 75)
                                    <span class="rounded-full bg-yellow-100 px-2 py-1 text-[11px] font-semibold text-yellow-800">
                                        {{ $progressRound }}%
                                    </span>
                                @else
                                    <span class="rounded-full bg-green-100 px-2 py-1 text-[11px] font-semibold text-green-600">
                                        {{ $progressRound }}%
                                    </span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endforeach

                </tr>

                {{-- Kabupaten Rows --}}
                @foreach($prov['kabupatens'] as $kab)
                    <tr
                        x-show="openRows[{{ $prov['id'] }}]"
                        x-transition>

                        <td class="border border-[#E5E7EB] py-3 pl-10">
                            Kab. {{ $kab['nama'] }}
                        </td>

                        @foreach([1, 2, 3, 5, 7] as $komId)
                            @php
                                $komData = $kab['komoditas'][$komId];
                            @endphp
                            <td class="border text-center">
                                {{ $komData['target'] > 0 ? number_format($komData['target'], 0, ',', '.') : '0' }}
                            </td>
                            <td class="border text-center">
                                {{ $komData['realisasi'] > 0 ? number_format($komData['realisasi'], 0, ',', '.') : '0' }}
                            </td>
                            <td class="border text-center">
                                @if($komData['target'] > 0)
                                    @php
                                        $progressRound = round($komData['progress']);
                                    @endphp
                                    @if($progressRound <= 50)
                                        <span class="rounded-full bg-red-100 px-2 py-1 text-[11px] font-semibold text-red-600">
                                            {{ $progressRound }}%
                                        </span>
                                    @elseif($progressRound <= 75)
                                        <span class="rounded-full bg-yellow-100 px-2 py-1 text-[11px] font-semibold text-yellow-800">
                                            {{ $progressRound }}%
                                        </span>
                                    @else
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-[11px] font-semibold text-green-600">
                                            {{ $progressRound }}%
                                        </span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach

                    </tr>
                @endforeach
            @endforeach

            </tbody>

        </table>

    </div>

</div>