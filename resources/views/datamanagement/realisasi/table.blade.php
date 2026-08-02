<div class="mb-4 rounded-[18px] bg-white p-5 shadow-[0_4px_12px_rgba(0,0,0,0.08)]">

    <form id="formFilterRealisasi">

        {{-- Baris 1 --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">

            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Cari
                </label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kelompok tani, kegiatan, komoditas..."
                    class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">
            </div>

            {{-- Tahun --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Tahun
                </label>

                <select name="tahun" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">
                    <option value="">Semua Tahun</option>
                    @foreach(range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" @selected(request('tahun') == $y)>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Kegiatan --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Kegiatan
                </label>

                <select name="kegiatan_id" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px] outline-none focus:border-[#15803D]">
                    <option value="">Semua Kegiatan</option>
                    @foreach($kegiatans as $item)
                        <option value="{{ $item->id }}" @selected(request('kegiatan_id') == $item->id)>
                            {{ $item->nama_kegiatan }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Baris 2 --}}
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">

            {{-- Komoditas --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Komoditas
                </label>

                <select name="komoditas_id" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">
                    <option value="">Semua Komoditas</option>
                    @foreach($komoditas as $item)
                        <option value="{{ $item->id }}" @selected(request('komoditas_id') == $item->id)>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Provinsi --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Provinsi
                </label>

                <select name="provinsi_id" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinsis as $item)
                        <option value="{{ $item->id }}" @selected(request('provinsi_id') == $item->id)>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kabupaten --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Kabupaten
                </label>

                <select name="kabupaten_id" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">
                    <option value="">Semua Kabupaten</option>
                    @foreach($kabupatens as $item)
                        <option value="{{ $item->id }}" @selected(request('kabupaten_id') == $item->id)>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Kecamatan
                </label>

                <select name="kecamatan_id" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatans as $item)
                        <option value="{{ $item->id }}" @selected(request('kecamatan_id') == $item->id)>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="mb-2 block text-[13px] font-semibold text-[#374151]">
                    Status
                </label>

                <select name="status" class="h-[42px] w-full rounded-[10px] border border-[#D1D5DB] px-3 text-[14px]">
                    <option value="">Semua Status</option>
                    <option value="Bantuan Sudah Diterima" @selected(request('status') == 'Bantuan Sudah Diterima')>Bantuan Sudah Diterima</option>
                    <option value="Bantuan Belum Diterima" @selected(request('status') == 'Bantuan Belum Diterima')>Bantuan Belum Diterima</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div>
                <label class="mb-2 block opacity-0">Action</label>

                <div class="flex h-[42px] gap-2">

                    <button
                        type="button"
                        id="btnResetFilterRealisasi"
                        class="flex-1 rounded-[10px] border border-[#D1D5DB] bg-white text-[14px] font-semibold text-[#374151] transition hover:bg-gray-100">
                        Reset
                    </button>

                    <button
                        type="submit"
                        class="flex flex-1 items-center justify-center rounded-[10px] bg-[#15803D] text-[14px] font-semibold text-white transition hover:bg-[#166534]">
                        Filter
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

<div class="overflow-hidden rounded-[14px] bg-white shadow-[0_3px_10px_rgba(0,0,0,0.08)]">

    <div class="overflow-x-auto">

        <table class="min-w-[1250px] w-full">

            <thead class="bg-[#F5FFF7]">

                <tr class="border-b border-[#E5E7EB]">
                    <th class="px-3 py-3 text-center text-[12px] font-bold">No</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kegiatan</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Komoditas</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kelompok Tani</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Desa</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kecamatan</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Kabupaten</th>
                    <th class="px-3 py-3 text-left text-[12px] font-bold">Provinsi</th>
                    <th class="px-3 py-3 text-center text-[12px] font-bold">Tahun</th>
                    <th class="px-3 py-3 text-center text-[12px] font-bold">Realisasi</th>
                    <th class="px-3 py-3 text-center text-[12px] font-bold">Status</th>
                    <th class="px-3 py-3 text-center text-[12px] font-bold">Aksi</th>
                </tr>

            </thead>

            <tbody class="text-[12px]">
                @forelse($realisasi as $item)

                <tr class="border-b hover:bg-[#FAFAFA]">

                    <td class="px-3 py-3 text-center font-semibold">
                        {{ $loop->iteration + ($realisasi->currentPage() - 1) * $realisasi->perPage() }}
                    </td>

                    <td class="px-3 py-3">{{ $item->kegiatan?->nama_kegiatan }}</td>
                    <td class="px-3 py-3">{{ $item->komoditas?->nama }}</td>
                    <td class="px-3 py-3">{{ $item->nama_kelompok }}</td>
                    <td class="px-3 py-3">{{ $item->desa?->nama }}</td>
                    <td class="px-3 py-3">{{ $item->kecamatan?->nama }}</td>
                    <td class="px-3 py-3">{{ $item->kabupaten?->nama }}</td>
                    <td class="px-3 py-3">{{ $item->provinsi?->nama }}</td>
                    <td class="px-3 py-3 text-center">{{ $item->tahun }}</td>

                    <td class="px-3 py-3 text-center font-semibold text-[#15803D]">
                        {{ number_format($item->jumlah_output, 2, ',', '.') }}
                        {{ $item->satuan?->nama }}
                    </td>

                    <td class="px-3 py-3 text-center">
                        <span class="inline-flex rounded-md px-2 py-1 text-[10px] font-semibold
                            {{ $item->status === 'Bantuan Sudah Diterima' ? 'bg-[#EAF8EC] text-[#15803D]' : 'bg-[#FEF2F2] text-[#DC2626]' }}">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td class="px-3 py-3">
                        <div class="flex justify-center gap-1.5">

                            <button
                                class="btnEditRealisasi flex h-7 w-7 items-center justify-center rounded-md border border-[#16A34A] text-[#16A34A]"
                                data-id="{{ $item->id }}">
                                ✏️
                            </button>

                            <button
                                class="btnDeleteRealisasi flex h-7 w-7 items-center justify-center rounded-md border border-[#EF4444] text-[#EF4444]"
                                data-id="{{ $item->id }}">
                                🗑️
                            </button>

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="12" class="py-8 text-center text-gray-500">
                        Tidak ada data.
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>

    </div>

    <div class="flex items-center justify-between border-t px-4 py-3">

        <p class="text-[12px] text-gray-500">
            Menampilkan
            {{ $realisasi->firstItem() ?? 0 }}
            -
            {{ $realisasi->lastItem() ?? 0 }}
            dari
            {{ $realisasi->total() }}
            data
        </p>

        <div>
            {{ $realisasi->links() }}
        </div>

    </div>
</div>

@include('datamanagement.realisasi.modal-create')