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

    <form id="filterForm">

    <input type="hidden"
           name="tahun"
           value="{{ request('tahun', date('Y')) }}">

    <div class="flex flex-wrap gap-6">

        <div>

            <label class="mb-2 block text-sm font-medium">
                Komoditas
            </label>

            <select
                id="komoditasFilter"
                name="komoditas"
                class="h-11 w-[200px] rounded-xl border border-gray-200 px-4">

                @foreach($komoditas as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ request('komoditas') == $item->id ? 'selected' : '' }}>

                        {{ $item->nama }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

        

    </div>

   {{-- Map Section --}}
<div>

    <div class="relative  rounded-3xl bg-white">

        <div
            id="indonesiaMap"
            class="h-[500px] w-full">
        </div>

    </div>

</div>

        

            

    {{-- Legend --}}
    <div
    class="flex flex-wrap items-center gap-6 rounded-2xl border border-gray-200 bg-white p-5">

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#14532D]"></div>
        <span class="text-sm">≥ 90% (Sangat Tinggi)</span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#15803D]"></div>
        <span class="text-sm">70% - 90%</span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#22C55E]"></div>
        <span class="text-sm">50% - 70%</span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#86EFAC]"></div>
        <span class="text-sm">30% - 50%</span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#DCFCE7]"></div>
        <span class="text-sm">&lt; 30%</span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#D1D5DB]"></div>
        <span class="text-sm">Tidak Ada Data</span>
    </div>

</div>


<script>

window.addEventListener('load', async function () {

    const chartDom = document.getElementById('indonesiaMap');

    const chart = echarts.init(chartDom);

    const observer = new ResizeObserver(() => {
    chart.resize();
    });

    

    observer.observe(chartDom);

    const geoJson = await fetch('/geojson/indonesia-provinsi.json')
        .then(res => res.json());

    geoJson.features.forEach(feature => {

    feature.properties.name =
        feature.properties.PROVINSI.toUpperCase();

});

    echarts.registerMap(
    'Indonesia',
    geoJson,
    {
        nameProperty: 'PROVINSI'
    }
);
    console.log(geoJson.features[0].properties);

    console.log(@json($mapData));
    chart.setOption({

    tooltip: {
        trigger: 'item',

        formatter: function (params) {

            const value = Array.isArray(params.value)
                ? params.value[2]
                : params.value;

            if (
                value === null ||
                value === undefined ||
                value === '-' ||
                isNaN(value)
        ) {

            return `
                <b>${params.name}</b><br>
                Progress : <b>Tidak Ada Data</b>
            `;

        }

            return `
                <b>${params.name}</b><br>
                Progress : <b>${Number(value).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                })}%</b>
            `;

        }
},

        visualMap: {
            min: 0,
            max: 100,
            show: false,
            inRange: {
                color: [
                    '#DCFCE7',
                    '#86EFAC',
                    '#4ADE80',
                    '#22C55E',
                    '#15803D'
                ]
            }
        },

        series: [

            {

                type: 'map',

                map: 'Indonesia',

                roam: false,

                zoom: 1.20,

                scaleLimit:{
                min:1.20,
                max:1.20
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

                data: @json($mapData)

            }

        ]

    });

    window.addEventListener('resize', () => chart.resize());

    const komoditasFilter = document.getElementById('komoditasFilter');

    komoditasFilter.addEventListener('change', async function () {

    const komoditas = this.value;

    const tahun =
    document.querySelector('input[name="tahun"]').value;

    const response = await fetch(
    `/dashboard/map-data?komoditas=${komoditas}&tahun=${tahun}`
    );

    const data = await response.json();

    chart.setOption({

    series: [{

        type: 'map',

        map: 'Indonesia',

        data: data

    }]

    });

});

});

</script>