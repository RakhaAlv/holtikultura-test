<form
    id="formFilterTarget"
    class="mb-4 flex flex-wrap items-end gap-3 rounded-[14px] bg-white p-4 shadow">

    <div class="min-w-[200px] flex-1">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Cari
        </label>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari kegiatan, komoditas, provinsi, kabupaten..."
            class="w-full rounded-lg border p-2.5 text-sm">
    </div>

    <div class="w-[130px]">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Tahun
        </label>
        <select name="tahun" class="w-full rounded-lg border p-2.5 text-sm">
            <option value="">Semua</option>
            @foreach(range(now()->year, now()->year - 5) as $y)
                <option value="{{ $y }}" @selected(request('tahun') == $y)>{{ $y }}</option>
            @endforeach
        </select>
    </div>

    <div class="w-[180px]">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Komoditas
        </label>
        <select name="komoditas_id" class="w-full rounded-lg border p-2.5 text-sm">
            <option value="">Semua</option>
            @foreach($komoditas as $item)
                <option value="{{ $item->id }}" @selected(request('komoditas_id') == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="w-[180px]">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Provinsi
        </label>
        <select name="provinsi_id" class="w-full rounded-lg border p-2.5 text-sm">
            <option value="">Semua</option>
            @foreach($provinsis as $item)
                <option value="{{ $item->id }}" @selected(request('provinsi_id') == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="w-[180px]">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Kabupaten
        </label>
        <select name="kabupaten_id" class="w-full rounded-lg border p-2.5 text-sm">
            <option value="">Semua</option>
            @foreach($kabupatens as $item)
                <option value="{{ $item->id }}" @selected(request('kabupaten_id') == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
    </div>

    @if(auth()->user()->isSuperAdmin())
    <div class="w-[180px]">
        <label class="mb-1 block text-xs font-semibold text-gray-500">
            Direktorat
        </label>
        <select name="direktorat_id" class="w-full rounded-lg border p-2.5 text-sm">
            <option value="">Semua</option>
            @foreach($direktorats as $item)
                <option value="{{ $item->id }}" @selected(request('direktorat_id') == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="flex gap-2">
        <button
            type="submit"
            class="h-[42px] rounded-lg bg-[#15803D] px-5 text-sm font-semibold text-white hover:bg-[#166534]">
            Filter
        </button>

        <button
            type="button"
            id="btnResetFilterTarget"
            class="h-[42px] rounded-lg border border-gray-300 px-5 text-sm font-semibold text-gray-600 hover:bg-gray-100">
            Reset
        </button>
    </div>

</form>

<div class="overflow-hidden rounded-[14px] bg-white shadow">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-[#F5FFF7]">

                <tr>
                    <th class="px-3 py-3 text-center">No</th>
                    <th class="px-3 py-3">Direktorat</th>
                    <th class="px-3 py-3">Kegiatan</th>
                    <th class="px-3 py-3">Komoditas</th>
                    <th class="px-3 py-3">Provinsi</th>
                    <th class="px-3 py-3">Kabupaten</th>
                    <th class="px-3 py-3 text-center">Tahun</th>
                    <th class="px-3 py-3 text-center">Target</th>
                    <th class="px-3 py-3 text-center">Satuan</th>
                    <th class="px-3 py-3 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($targets as $target)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-3 py-3 text-center">
                        {{ $loop->iteration + ($targets->currentPage()-1) * $targets->perPage() }}
                    </td>

                    <td class="px-3 py-3">
                        {{ $target->direktorat?->nama }}
                    </td>

                    <td class="px-3 py-3">
                        {{ $target->kegiatan?->nama_rincian_output }}
                    </td>

                    <td class="px-3 py-3">
                        {{ $target->komoditas?->nama }}
                    </td>

                    <td class="px-3 py-3">
                        {{ $target->provinsi?->nama }}
                    </td>

                    <td class="px-3 py-3">
                        {{ $target->kabupaten?->nama }}
                    </td>

                    <td class="px-3 py-3 text-center">
                        {{ $target->tahun }}
                    </td>

                    <td class="px-3 py-3 text-center font-semibold text-black-600">
                        {{ number_format($target->target, 2, ',', '.') }}
                    </td>

                    <td class="px-3 py-3 text-center">
                        {{ $target->satuan?->nama }}
                    </td>

                    <td class="px-3 py-3">

                        <div class="flex justify-center gap-2">

                            <button
                                class="btnEditTarget rounded border border-green-600 px-3 py-1 text-green-600"
                                data-id="{{ $target->id }}">
                                Edit
                            </button>

                            <button
                                class="btnDeleteTarget rounded border border-red-600 px-3 py-1 text-red-600"
                                data-id="{{ $target->id }}">
                                Hapus
                            </button>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10" class="py-8 text-center text-gray-500">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex items-center justify-between border-t px-4 py-3">

        <p class="text-sm text-gray-500">

            Menampilkan

            {{ $targets->firstItem() ?? 0 }}

            -

            {{ $targets->lastItem() ?? 0 }}

            dari

            {{ $targets->total() }}

            data

        </p>

        {{ $targets->links() }}

    </div>
</div>
@include('datamanagement.target.modal-create')