{{-- Graph --}}

<div class="rounded-[22px] bg-white p-6 shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-4">

        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#D8EEFF]">

            <img
                src="{{ asset('Icon-Graph-Komoditas.svg') }}"
                class="h-8 w-8">

        </div>

        <div>

            <h2 class="text-[28px] font-semibold text-[#1F2937]">
                Grafik Capaian vs Target per Provinsi
            </h2>

            <p class="mt-1 text-[14px] text-[#7A7A7A]">
                Perbandingan target dan realisasi {{ $komoditas->nama }} pada setiap provinsi.
            </p>

        </div>

    </div>

{{-- Chart --}}
<div class="overflow-x-auto">

    <div
        id="chartWrapper"
        class="min-w-full">

        <div
            id="provinsiChart"
            class="h-[420px]">
        </div>

    </div>

</div>

{{-- Legend --}}
<div class="mt-6 flex justify-center gap-8">

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#66B8E8]"></div>
        <span class="text-sm text-gray-600">
            Target
        </span>
    </div>

    <div class="flex items-center gap-2">
        <div class="h-4 w-4 rounded bg-[#25CF4A]"></div>
        <span class="text-sm text-gray-600">
            Realisasi
        </span>
    </div>

</div>

</div>



    <script>

    window.addEventListener("load", function () {

    const chartDom = document.getElementById('provinsiChart');
    const wrapper = document.getElementById('chartWrapper');

    const chart = echarts.init(chartDom);

    const jumlahProvinsi = @json($chartData->count());
    const komoditas = @json($komoditas->nama);

    const satuan = komoditas.toLowerCase() === 'p2b'
        ? 'Kelompok'
        : 'Ha';

    const barWidth = jumlahProvinsi <= 10
        ? 40
            : jumlahProvinsi <= 20
        ? 34
        : 28;

// lebar minimum per provinsi
    let widthPerItem;

    if (jumlahProvinsi <= 10) {
        widthPerItem = 140;
    } else if (jumlahProvinsi <= 20) {
        widthPerItem = 110;
    } else {
        widthPerItem = 90;
    }
// total lebar chart
    const chartWidth = Math.max(
        jumlahProvinsi * widthPerItem,
        wrapper.parentElement.clientWidth
    );

// wrapper yang diperlebar
    wrapper.style.width = chartWidth + 'px';

// chart selalu mengikuti wrapper
    chartDom.style.width = '100%';
    chart.resize();

        new ResizeObserver(() => {

            chart.resize();

        }).observe(wrapper);

    const targetData = @json($chartData->pluck('target'));
    const realisasiData = @json($chartData->pluck('realisasi'));

    const maxValue = Math.max(
    ...targetData,
    ...realisasiData
    );

const splitNumber = 5;

// interval ideal
let interval = Math.ceil(maxValue / splitNumber);

// dibulatkan ke angka "cantik"
if (interval <= 10) {
    interval = Math.ceil(interval / 5) * 5;
} else if (interval <= 50) {
    interval = Math.ceil(interval / 10) * 10;
} else if (interval <= 100) {
    interval = Math.ceil(interval / 20) * 20;
} else if (interval <= 500) {
    interval = Math.ceil(interval / 50) * 50;
} else if (interval <= 1000) {
    interval = Math.ceil(interval / 100) * 100;
} else {
    interval = Math.ceil(interval / 500) * 500;
}

const maxAxis = interval * splitNumber;

    const option = {

        animationDuration:1000,

        grid:{
            top:35,
            left:60,
            right:40,
            bottom:80,
            containLabel:true
        },

        tooltip:{
            trigger:'axis',
            axisPointer:{
                type:'shadow'
            }
        },

        legend:{
            show: false,
            bottom: 10,
            left: 'center',
            itemWidth: 18,
            itemHeight: 12,
            itemGap: 20,
            textStyle: {
            fontSize: 14,
            color: '#555'
        }
    },

        xAxis:{

            type:'category',

            axisTick:{
                show:false
            },

            axisLabel:{
                interval:0,
                fontSize:11,
                margin:20,
                rotate:0,
                formatter: function (value) {
                    return value.split(' ').join('\n');
                }
            },

            data: @json($chartData->pluck('provinsi'))

        },

            yAxis: {
                type: 'value',

                name: satuan,

                max: maxAxis,

                interval: interval,

                splitNumber: splitNumber,

                axisLine: {
                    show: false
                },

                axisTick: {
                    show: false
                },

                splitLine: {
                    lineStyle: {
                    color: '#ECECEC'
            }   
        }
    },

        series:[

            {

                name:'Target',

                type:'bar',

                data: targetData,

                barWidth:barWidth,

                itemStyle:{
                    color:'#66B8E8',
                    borderRadius:[6,6,0,0]
                },

                label:{
                    show:true,
                    position:'top',
                    fontWeight:'600',
                formatter:function(params){
                return Number(params.value).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        }

            },

            {

                name:'Realisasi',

                type:'bar',

                data: realisasiData,

                barWidth:barWidth,

                itemStyle:{
                    color:'#25CF4A',
                    borderRadius:[6,6,0,0]
                },

                label:{
                    show:true,
                    position:'top',
                    formatter:function(params){

                    if (params.value == 0) {
                    return '';
                    }

                    return Number(params.value).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

            }
        }

            }

        ]

    };

    chart.setOption(option);

});

</script>
