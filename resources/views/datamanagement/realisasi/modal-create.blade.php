<div
    id="modalCreateRealisasi"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[90vh] w-[700px] overflow-y-auto rounded-xl bg-white p-6">

        <h2
            id="modalTitleRealisasi"
            class="mb-6 text-2xl font-bold">
            Tambah Realisasi
        </h2>

        <form
            id="formRealisasi"
            action="{{ route('management.realisasi.store') }}"
            method="POST"
            class="space-y-4">

            @csrf

            <div id="methodFieldRealisasi"></div>
            <input type="hidden" id="realisasiId">

            {{-- Tahun --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">Tahun</label>
                <input
                    id="tahunFieldR"
                    type="number"
                    name="tahun"
                    value="{{ date('Y') }}"
                    class="w-full rounded-lg border p-3"
                    required>
            </div>

            @if(auth()->user()->isSuperAdmin())
            <div>
                <label class="mb-2 block text-sm font-semibold">Direktorat</label>

                <select id="direktoratFieldR" name="direktorat_id" class="w-full rounded-lg border px-3 py-3" required>
                    <option value="">Pilih Direktorat</option>
                    @foreach($direktorats as $direktorat)
                        <option value="{{ $direktorat->id }}">{{ $direktorat->nama }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Kegiatan & Komoditas --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">Kegiatan</label>
                    <select id="kegiatanFieldR" name="kegiatan_id" class="w-full rounded-lg border p-3" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold">Komoditas</label>
                    <select id="komoditasFieldR" name="komoditas_id" class="w-full rounded-lg border p-3" required>
                        <option value="">Pilih Komoditas</option>
                        @foreach($komoditas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Kelompok Tani --}}
            <div>
                <label class="mb-2 block text-sm font-semibold">Kelompok Tani</label>
                <input
                    id="namaKelompokFieldR"
                    type="text"
                    name="nama_kelompok"
                    class="w-full rounded-lg border p-3"
                    required>
            </div>

            {{-- Provinsi & Kabupaten --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">Provinsi</label>
                    <select id="provinsiSelectR" name="provinsi_id" class="w-full rounded-lg border p-3" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinsis as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold">Kabupaten</label>
                    <select id="kabupatenSelectR" name="kabupaten_id" class="w-full rounded-lg border px-3 py-3" required>
                        <option value="">Pilih Kabupaten</option>
                    </select>
                </div>

            </div>

            {{-- Kecamatan & Desa --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">Kecamatan</label>
                    <select id="kecamatanSelectR" name="kecamatan_id" class="w-full rounded-lg border px-3 py-3" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold">Desa</label>
                    <select id="desaSelectR" name="desa_id" class="w-full rounded-lg border px-3 py-3" required>
                        <option value="">Pilih Desa</option>
                    </select>
                </div>

            </div>

            {{-- Satuan & Jumlah Output --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">Satuan</label>
                    <select id="satuanFieldR" name="satuan_id" class="w-full rounded-lg border p-3" required>
                        <option value="">Pilih Satuan</option>
                        @foreach($satuans as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold">Jumlah Realisasi</label>
                    <input
                        id="jumlahOutputFieldR"
                        type="number"
                        step="0.01"
                        name="jumlah_output"
                        class="w-full rounded-lg border p-3"
                        required>
                </div>

            </div>

            {{-- Anggaran & Status --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="mb-2 block text-sm font-semibold">Anggaran (opsional)</label>
                    <input
                        id="anggaranFieldR"
                        type="number"
                        step="0.01"
                        name="anggaran"
                        class="w-full rounded-lg border p-3">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold">Status Bantuan</label>
                    <select id="statusFieldR" name="status" class="w-full rounded-lg border p-3" required>
                        <option value="">Pilih Status</option>
                        <option value="Bantuan Sudah Diterima">Bantuan Sudah Diterima</option>
                        <option value="Bantuan Belum Diterima">Bantuan Belum Diterima</option>
                    </select>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <button
                    id="btnCloseRealisasi"
                    type="button"
                    class="rounded-lg border border-gray-300 px-5 py-2 hover:bg-gray-100">
                    Batal
                </button>

                <button
                    id="btnSaveRealisasi"
                    type="submit"
                    class="rounded-lg bg-[#15803D] px-5 py-2 text-white hover:bg-[#166534]">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>