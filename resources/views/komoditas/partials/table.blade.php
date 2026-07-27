<div
    x-data="{ openProvinces: {} }"
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
                Klik baris berikon panah untuk melihat rincian hingga tingkat Kabupaten/Kota.
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
                @foreach($tableData as $provId => $provData)
                    {{-- ========================= --}}
                    {{-- PROVINSI --}}
                    {{-- ========================= --}}
                    <tr
                        @click="openProvinces[{{ $provId }}] = !openProvinces[{{ $provId }}]"
                        class="cursor-pointer border-b bg-[#EEF3FF] transition hover:bg-[#E6EEFF]">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <svg
                                    class="h-4 w-4 transition duration-300"
                                    :class="{ 'rotate-90': openProvinces[{{ $provId }}] }"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path d="M9 5l7 7-7 7"/>

                                </svg>

                                <span class="text-[16px] font-semibold">
                                    {{ $provData['nama'] }}
                                </span>

                            </div>

                        </td>

                        <td class="text-center text-[15px]">
                            {{ number_format($provData['target'], 0, ',', '.') }} Ha
                        </td>

                        <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                            {{ number_format($provData['realisasi'], 0, ',', '.') }} Ha
                        </td>

                        <td class="text-center">
                            @php
                                if ($provData['progress'] >= 100) {
                                    $badge = 'bg-green-100 text-green-700';
                                } elseif ($provData['progress'] >= 80) {
                                    $badge = 'bg-yellow-100 text-yellow-700';
                                } else {
                                    $badge = 'bg-red-100 text-red-700';
                                }
                            @endphp
                            <span class="rounded-full px-3 py-1 text-[14px] font-semibold {{ $badge }}">
                                {{ number_format($provData['progress'], 2) }}%
                            </span>

                        </td>

                    </tr>

                    {{-- ========================= --}}
                    {{-- KABUPATEN --}}
                    {{-- ========================= --}}
                    @foreach($provData['kabupatens'] as $kabId => $kabData)
                        <tr
                            x-show="openProvinces[{{ $provId }}]"
                            x-transition
                            class="border-b">

                            <td class="py-4 pl-16 text-[15px]">
                                {{ $kabData['nama'] }}
                            </td>

                            <td class="text-center text-[15px]">
                                {{ number_format($kabData['target'], 0, ',', '.') }} Ha
                            </td>

                            <td class="text-center text-[15px] font-semibold text-[#00A63E]">
                                {{ number_format($kabData['realisasi'], 0, ',', '.') }} Ha
                            </td>

                            <td class="text-center">
                                @php
                                    if ($kabData['progress'] >= 100) {
                                        $badgeKab = 'bg-green-100 text-green-700';
                                    } elseif ($kabData['progress'] >= 80) {
                                        $badgeKab = 'bg-yellow-100 text-yellow-700';
                                    } else {
                                        $badgeKab = 'bg-red-100 text-red-700';
                                    }
                                @endphp
                                <span class="rounded-full px-3 py-1 text-[14px] font-semibold {{ $badgeKab }}">
                                    {{ number_format($kabData['progress'], 2) }}%
                                </span>

                            </td>

                        </tr>
                    @endforeach
                @endforeach
            </tbody>

        </table>

    </div>

</div>