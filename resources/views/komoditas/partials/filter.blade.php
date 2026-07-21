<div class="rounded-[24px] bg-white p-8 shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

    {{-- Header --}}
    <div class="mb-8 flex items-center gap-5">

        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#B8F0C6]">

            <img
                src="{{ asset('Icon-Filter-Lokasi.svg') }}"
                class="h-12 w-12">

        </div>

        <h2 class="text-[30px] font-bold">
            Filter Lokasi & Direktorat
        </h2>

    </div>

    {{-- Filter --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        {{-- Provinsi --}}
        <div>

            <label class="mb-3 block text-[18px] font-semibold">
                Provinsi
            </label>

            <select class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] px-5">

                <option>Semua Provinsi</option>

            </select>

        </div>

        {{-- Kabupaten --}}
        <div>

            <label class="mb-3 block text-[18px] font-semibold">
                Kabupaten/Kota
            </label>

            <select class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] px-5">

                <option>Semua Kabupaten/Kota</option>

            </select>

        </div>

        {{-- Kecamatan --}}
        <div>

            <label class="mb-3 block text-[18px] font-semibold">
                Kecamatan
            </label>

            <select class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] px-5">

                <option>Semua Kecamatan</option>

            </select>

        </div>

    </div>

</div>