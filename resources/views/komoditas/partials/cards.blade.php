@php
    $satuan = strtolower($komoditas->nama) === 'p2b'
        ? 'Kelompok'
        : 'Ha';
@endphp

{{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Target --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#64B5F6]"></div>

            <div class="flex items-center justify-between px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D8EEFF]">

                        <img
                            src="{{ asset('Icon-Target.svg') }}"
                            class="h-9 w-9">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Total Target
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                            {{ number_format($totalTarget,0,',','.') }}
                        </h2>

                     <p class="mt-1 text-[18px] text-[#555]">
                        {{ $satuan }}
                    </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Realisasi --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#57D67A]"></div>

            <div class="flex items-center justify-between px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#CFF5DA]">

                        <img
                            src="{{ asset('Icon-Realisasi.svg') }}"
                            class="h-12 w-12">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Total Realisasi
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                            {{ number_format($totalRealisasi,0,',','.') }}
                        </h2>

                        <p class="mt-1 text-[18px] text-[#555]">
                            {{ $satuan }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Persentase --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#FFD54F]"></div>

            <div class="px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#FFF5BF]">

                        <img
                            src="{{ asset('Icon-Persentase.svg') }}"
                            class="h-9 w-9">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Persentase Capaian
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                           {{ $progress }}%
                        </h2>

                    </div>

                </div>

                {{-- Progress --}}
                <div class="mt-6">

                    <div class="h-[8px] overflow-hidden rounded-full bg-[#D8D8D8]">

                        <div
                            class="h-full rounded-full bg-[#E83D5A]"
                            style="width: {{ min($progress,100) }}%">
                        </div>

                    </div>

                </div>
                
            </div>

        </div>

    </div>
