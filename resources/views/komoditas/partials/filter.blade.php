<div class="rounded-[18px] bg-white p-5 shadow-[0_6px_18px_rgba(0,0,0,0.08)]">

    {{-- Header --}}
    <div class="mb-5 flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#B8F0C6]">

            <img
                src="{{ asset('Icon-Filter-Lokasi.svg') }}"
                class="h-12 w-12">

        </div>

        <h2 class="text-[22px] font-bold text-[#111827]">
            Filter Lokasi & Direktorat
        </h2>

    </div>

    {{-- Filter --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

        {{-- Provinsi --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Provinsi
            </label>

            <select
                class="h-[44px] w-full rounded-[10px] border-2 border-[#2D2D2D] bg-white px-4 text-[15px] outline-none">

                <option>Semua Provinsi</option>

            </select>

        </div>

        {{-- Kabupaten --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Kabupaten/Kota
            </label>

            <select
                class="h-[44px] w-full rounded-[10px] border-2 border-[#2D2D2D] bg-white px-4 text-[15px] outline-none">

                <option>Semua Kabupaten/Kota</option>

            </select>

        </div>

        {{-- Kecamatan --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Kecamatan
            </label>

            <select
                class="h-[44px] w-full rounded-[10px] border-2 border-[#2D2D2D] bg-white px-4 text-[15px] outline-none">

                <option>Semua Kecamatan</option>

            </select>

        </div>

    </div>

</div>