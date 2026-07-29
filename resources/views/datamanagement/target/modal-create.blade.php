<div
    id="modalCreateTarget"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-[700px] rounded-xl bg-white p-6">

        <h2 class="mb-6 text-2xl font-bold">

            Tambah Target

        </h2>

        <form
            action="{{ route('management.target.store') }}"
            method="POST">

            @csrf

            <div class="grid grid-cols-2 gap-5">

    {{-- Tahun --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Tahun
        </label>

        <input
            type="number"
            name="tahun"
            value="{{ date('Y') }}"
            class="w-full rounded-lg border p-3"
            required>
    </div>
@if(auth()->user()->isSuperAdmin())

<div>
    <label class="mb-2 block text-sm font-semibold">
        Direktorat
    </label>

    <select
        name="direktorat_id"
        class="w-full rounded-lg border px-3 py-2"
        required>

        <option value="">Pilih Direktorat</option>

        @foreach($direktorats as $direktorat)
            <option value="{{ $direktorat->id }}">
                {{ $direktorat->nama }}
            </option>
        @endforeach

    </select>
</div>

@endif

    {{-- Kegiatan --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Kegiatan
        </label>

        <select
            name="kegiatan_id"
            class="w-full rounded-lg border p-3"
            required>

            <option value="">Pilih Kegiatan</option>

            @foreach($kegiatans as $kegiatan)

                <option value="{{ $kegiatan->id }}">
                    {{ $kegiatan->nama_kegiatan }}
                </option>

            @endforeach

        </select>
    </div>

    {{-- Komoditas --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Komoditas
        </label>

        <select
            name="komoditas_id"
            class="w-full rounded-lg border p-3"
            required>

            <option value="">Pilih Komoditas</option>

            @foreach($komoditas as $item)

                <option value="{{ $item->id }}">
                    {{ $item->nama }}
                </option>

            @endforeach

        </select>
    </div>

    {{-- Satuan --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Satuan
        </label>

        <select
            name="satuan_id"
            class="w-full rounded-lg border p-3"
            required>

            <option value="">Pilih Satuan</option>

            @foreach($satuans as $item)

                <option value="{{ $item->id }}">
                    {{ $item->nama }}
                </option>

            @endforeach

        </select>
    </div>

    {{-- Provinsi --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Provinsi
        </label>

        <select
            id="provinsiSelect"
            name="provinsi_id"
            class="w-full rounded-lg border p-3"
            required>

            <option value="">Pilih Provinsi</option>

            @foreach($provinsis as $item)

                <option value="{{ $item->id }}">
                    {{ $item->nama }}
                </option>

            @endforeach

        </select>
    </div>

    {{-- Kabupaten --}}
    <div>
        <label class="mb-2 block text-sm font-semibold">
            Kabupaten
        </label>

        <select
    name="kabupaten_id"
    class="w-full rounded-lg border px-3 py-2"
    required>

    <option value="">Pilih Kabupaten</option>

    @foreach($kabupatens as $kabupaten)

        <option value="{{ $kabupaten->id }}">

            {{ $kabupaten->nama }}

        </option>

    @endforeach

</select>
    </div>

</div>

<div class="mt-5">

    <label class="mb-2 block text-sm font-semibold">

        Target

    </label>

    <input
        type="number"
        step="0.01"
        name="target"
        class="w-full rounded-lg border p-3"
        required>

</div>

            <div class="mt-8 flex justify-end gap-3">

                <button
                    id="btnCloseTarget"
                    type="button"
                    class="rounded-lg border border-gray-300 px-5 py-2 hover:bg-gray-100">

                    Batal

                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-[#15803D] px-5 py-2 text-white hover:bg-[#166534]">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>