<div class="rounded-[18px] bg-white p-5 shadow-[0_4px_12px_rgba(0,0,0,0.08)]">

    {{-- Baris 1 --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">

        {{-- Tahun --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Tahun
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">

                <option>2025</option>

            </select>

        </div>

        {{-- Kegiatan --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Kegiatan
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">

                <option>Peningkatan Produksi</option>

            </select>

        </div>

        {{-- Komoditas --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Komoditas
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">

                <option>🌶 Cabai</option>

            </select>

        </div>

    </div>

    {{-- Baris 2 --}}
    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

        {{-- Provinsi --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Provinsi
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">

                <option>Semua Provinsi</option>

            </select>

        </div>

        {{-- Kabupaten --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Kabupaten
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">

                <option>Semua Kabupaten</option>

            </select>

        </div>

        {{-- Kecamatan --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Kecamatan
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">

                <option>Semua Kecamatan</option>

            </select>

        </div>

        {{-- Status --}}
        <div>

            <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                Status
            </label>

            <select class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">

                <option>Semua Status</option>

            </select>

        </div>

        {{-- Tombol --}}
        <div>

            <label class="mb-2 block opacity-0">
                Action
            </label>

                <div class="flex h-[42px] gap-2">

                {{-- Reset --}}
                    <button
                        class="flex-1 rounded-[10px] border border-[#D1D5DB] bg-white text-[14px] font-semibold text-[#374151] transition hover:bg-gray-100">

                        Reset

                    </button>

                <button
                    class="flex flex-1 items-center justify-center rounded-[10px] bg-[#15803D] text-[14px] font-semibold text-white transition hover:bg-[#166534]">

                    Filter

                </button>

            </div>

        </div>

    </div>

</div>