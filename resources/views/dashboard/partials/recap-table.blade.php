<div class="overflow-hidden rounded-[24px] bg-white">

    <!-- Header -->
    <div class="px-1 pt-1">

        <h2 class="text-[28px] font-semibold text-[#222]">
            Rekapitulasi Capaian Kegiatan Hortikultura
        </h2>

        <p class="mt-2 text-[15px] text-gray-500">
            Klik baris berikon panah untuk melihat rincian hingga tingkat kelompok tani.
        </p>

    </div>
    

    <!-- Table -->

   <table class="w-full table-fixed border-collapse">

    <thead>

        <tr class="bg-[#ECECEC] text-[15px] font-semibold uppercase text-[#333]">

            <th class="w-[22%] px-8 py-5 text-left">
                Komoditas
            </th>

            <th class="w-[25%] px-6 py-5 text-left">
                Wilayah
            </th>

            <th class="w-[18%] px-6 py-5 text-center">
                Target
            </th>

            <th class="w-[18%] px-6 py-5 text-center">
                Realisasi
            </th>

            <th class="w-[17%] px-6 py-5 text-center">
                Persentase
            </th>

        </tr>

    </thead>

    @include('dashboard.partials.recap-table-body')

    </table>

</div>