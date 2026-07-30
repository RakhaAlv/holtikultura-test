<div
    id="modalCreateTarget"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[90vh] w-[700px] overflow-y-auto rounded-xl bg-white p-6">

        <h2
            id="modalTitle"
            class="mb-6 text-2xl font-bold">

            Tambah Target

        </h2>

        <form
            id="formTarget"
            action="{{ route('management.target.store') }}"
            method="POST"
            class="space-y-4">

            @csrf

            <div id="methodField"></div>
            <input
                type="hidden"
                id="targetId">

            {{-- Tahun --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Tahun
                </label>

                <input
                    id="tahunField"
                    type="number"
                    name="tahun"
                    value="{{ date('Y') }}"
                    class="w-full rounded-lg border p-3"
                    required>
            </div>

            @if(auth()->user()->isSuperAdmin())

            {{-- Direktorat --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Direktorat
                </label>

                <select
                    id="direktoratField"
                    name="direktorat_id"
                    class="w-full rounded-lg border px-3 py-3"
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

            {{-- Kegiatan & Komoditas --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">
                        Kegiatan
                    </label>

                    <select
                        id="kegiatanField"
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

                <div>
                    <label class="mb-2 block text-sm font-semibold">
                        Komoditas
                    </label>

                    <select
                        id="komoditasField"
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

            </div>

            {{-- Satuan --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Satuan
                </label>

                <select
                    id="satuanField"
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

            {{-- Provinsi & Kabupaten --}}
            <div class="grid grid-cols-2 gap-4">

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

                <div>
                    <label class="mb-2 block text-sm font-semibold">
                        Kabupaten
                    </label>

                    <select
                        id="kabupatenSelect"
                        name="kabupaten_id"
                        class="w-full rounded-lg border px-3 py-3"
                        required>

                        <option value="">
                            Pilih Kabupaten
                        </option>

                    </select>
                </div>

            </div>

            {{-- Target --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Target
                </label>

                <input
                    id="targetField"
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
                    id="btnSaveTarget"
                    type="submit"
                    class="rounded-lg bg-[#15803D] px-5 py-2 text-white hover:bg-[#166534]">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>