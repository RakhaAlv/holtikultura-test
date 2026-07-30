<div class="overflow-hidden rounded-[14px] bg-white shadow">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-[#F5FFF7]">

                <tr>

                    <th class="px-4 py-3 text-center">No</th>

                    <th class="px-4 py-3">Kegiatan</th>

                    <th class="px-4 py-3">Komoditas</th>

                    <th class="px-4 py-3">Provinsi</th>

                    <th class="px-4 py-3">Kabupaten</th>

                    <th class="px-4 py-3 text-center">Target</th>

                    <th class="px-4 py-3 text-center">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($targets as $target)

                <tr class="border-b">

                    <td class="px-4 py-3 text-center">

                        {{ $loop->iteration + ($targets->currentPage()-1)*$targets->perPage() }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $target->kegiatan?->nama_kegiatan }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $target->komoditas?->nama }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $target->provinsi?->nama }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $target->kabupaten?->nama }}

                    </td>

                    <td class="px-4 py-3 text-center">

                        {{ number_format($target->target,2,',','.') }}

                        {{ $target->satuan?->nama }}

                    </td>

                    <td class="px-4 py-3 text-center">

                        <button class="text-green-600">

                            Edit

                        </button>

                        |

                        <button class="text-red-600">

                            Hapus

                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="py-8 text-center">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="border-t p-4">

        {{ $targets->links() }}

    </div>
    @include('datamanagement.target.modal-create')

</div>