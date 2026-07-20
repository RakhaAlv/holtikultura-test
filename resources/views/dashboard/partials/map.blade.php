<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h2 class="text-[30px] font-semibold text-[#1F2937]">
            Peta Persebaran Capaian Hortikultura
        </h2>

        <p class="mt-2 text-[15px] text-[#7B7B7B]">
            Visualisasi capaian target berdasarkan wilayah di seluruh Indonesia.
        </p>
    </div>

    {{-- Filter --}}
    <div class="flex flex-wrap items-center justify-between gap-6">

        <div class="flex flex-wrap items-center gap-8">

            {{-- Komoditas --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Komoditas
                </label>

                <select
                    class="h-11 w-[250px] rounded-xl border border-gray-200 bg-white px-4 shadow-sm outline-none transition focus:border-[#16B33A]">

                    <option>Cabai</option>
                    <option>Bawang Putih</option>
                    <option>Bawang Merah</option>
                    <option>Durian</option>

                </select>

            </div>

            {{-- Tahun --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Tahun
                </label>

                <select
                    class="h-11 w-[160px] rounded-xl border border-gray-200 bg-white px-4 shadow-sm outline-none transition focus:border-[#16B33A]">

                    <option>2025</option>
                    <option>2024</option>
                    <option>2023</option>

                </select>

            </div>

            {{-- Periode --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Periode
                </label>

                <select
                    class="h-11 w-[220px] rounded-xl border border-gray-200 bg-white px-4 shadow-sm outline-none transition focus:border-[#16B33A]">

                    <option>Januari - Juni</option>
                    <option>Juli - Desember</option>

                </select>

            </div>

        </div>

        {{-- Last Update --}}
        <div
            class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white px-6 py-4 shadow-sm">

            <div
                class="flex h-11 w-11 items-center justify-center rounded-full bg-red-50">

                <img
                    src="{{ asset('Icon-UpdateData.svg') }}"
                    class="h-6 w-6">

            </div>

            <div>

                <p class="text-[13px] text-gray-500">

                    Data diperbarui

                </p>

                <p class="text-[15px] font-semibold text-gray-800">

                    10 Juni 2025

                </p>

                <p class="text-[13px] text-gray-500">

                    10:30 WIB

                </p>

            </div>

        </div>

    </div>

    {{-- Map Section --}}
    <div class="grid grid-cols-12 gap-8">

            {{-- MAP --}}
            <div class="col-span-9">

                <div class="relative h-[520px] rounded-3xl bg-white">

                    <div
                        id="indonesiaMap"
                        class="h-full w-full">
                    </div>

                </div>

            </div>

        {{-- Sidebar --}}
        <div class="col-span-3 space-y-6">

            {{-- Top 5 --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h3 class="mb-6 text-lg font-semibold">

                    Top 5 Provinsi (Capaian)

                </h3>

                @php

                    $top = [

                        ['Jawa Barat',95.8],
                        ['Jawa Tengah',82.3],
                        ['Jawa Timur',74.6],
                        ['Sumatera Utara',63.1],
                        ['Sulawesi Selatan',58.7]

                    ];

                @endphp

                @foreach($top as $i=>$item)

                <div class="mb-5">

                    <div class="mb-2 flex justify-between text-sm">

                        <span>

                            {{ $i+1 }}. {{ $item[0] }}

                        </span>

                        <span class="font-semibold text-red-600">

                            {{ $item[1] }}%

                        </span>

                    </div>

                    <div class="h-2 rounded-full bg-gray-200">

                        <div
                            class="h-2 rounded-full bg-gradient-to-r from-red-400 to-red-600"
                            style="width:{{ $item[1] }}%">

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            {{-- Info --}}
            <div
                class="flex gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold">

                    i

                </div>

                <p class="text-sm leading-6 text-gray-600">

                    Klik pada provinsi untuk melihat detail capaian.

                </p>

            </div>

        </div>

    </div>

    {{-- Legend --}}
    <div
        class="flex flex-wrap items-center gap-8 rounded-2xl border border-gray-200 bg-white p-6">

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#8B0000]"></div>
            <span class="text-sm">≥ 90% (Sangat Tinggi)</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#E11D1D]"></div>
            <span class="text-sm">70% - 90%</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#FF6B35]"></div>
            <span class="text-sm">50% - 70%</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#FFA24A]"></div>
            <span class="text-sm">30% - 50%</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#FFD1C2]"></div>
            <span class="text-sm">&lt; 30%</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="h-5 w-5 rounded bg-[#CFCFCF]"></div>
            <span class="text-sm">Tidak Ada Data</span>
        </div>

    </div>

</div>  


<script>

window.addEventListener('load', async function () {

    const chartDom = document.getElementById('indonesiaMap');

    const chart = echarts.init(chartDom);

    const geoJson = await fetch('/geojson/indonesia-provinsi.json')
        .then(res => res.json());

    echarts.registerMap('Indonesia', geoJson);

    chart.setOption({

        tooltip: {
            trigger: 'item'
        },

        visualMap: {
            min: 0,
            max: 100,
            show: false,
            inRange: {
                color: [
                    '#FFE6D5',
                    '#FDBA74',
                    '#FB923C',
                    '#F97316',
                    '#DC2626'
                ]
            }
        },

        series: [

            {

                type: 'map',

                map: 'Indonesia',

                roam: false,

                zoom: 1.15,           // atur ukuran awal
                scaleLimit: {
                min: 1.15,
                max: 1.15
                },

                selectedMode: false,  // tidak bisa dipilih

                emphasis: {

                    label: {
                        show: false
                    },

                    itemStyle: {
                        areaColor: '#16B33A'
                    }

                },

                data: [

                    { name: 'Aceh', value: 80 },
                    { name: 'Sumatera Utara', value: 65 },
                    { name: 'Sumatera Barat', value: 50 },
                    { name: 'Riau', value: 75 },
                    { name: 'Jawa Barat', value: 95 },
                    { name: 'Jawa Tengah', value: 82 },
                    { name: 'Jawa Timur', value: 74 },
                    { name: 'Banten', value: 61 },
                    { name: 'DKI Jakarta', value: 48 },
                    { name: 'Bali', value: 58 }

                ]

            }

        ]

    });

    window.addEventListener('resize', () => chart.resize());

});

</script>