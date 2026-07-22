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
                Perbandingan target dan realisasi Bawang Putih pada setiap provinsi.
            </p>

        </div>

    </div>

    {{-- Chart --}}
    <div
        id="provinsiChart"
        class="h-[420px] w-full">
    </div>

</div>


    <script>

    window.addEventListener("load", function () {

    const chartDom = document.getElementById('provinsiChart');

    const chart = echarts.init(chartDom);

    new ResizeObserver(() => {

        chart.resize();

    }).observe(chartDom);

    const option = {

        animationDuration:1000,

        grid:{
            top:35,
            left:60,
            right:30,
            bottom:90,
            containLabel:true
        },

        tooltip:{
            trigger:'axis',
            axisPointer:{
                type:'shadow'
            }
        },

        legend:{
            bottom:15
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
                rotate:0
            },

            data:[

                'Aceh',
                'Sumatera\nUtara',
                'Sumatera\nBarat',
                'Jambi',
                'Sumatera\nSelatan',
                'Bengkulu',
                'Lampung',
                'Jawa\nBarat',
                'Jawa\nTengah',
                'DI\nYogyakarta',
                'Jawa\nTimur',
                'Bali',
                'NTB',
                'NTT',
                'Sulawesi\nUtara',
                'Sulawesi\nTengah',
                'Sulawesi\nSelatan',
                'Gorontalo',
                'Sulawesi\nBarat'

            ]

        },

        yAxis:{

            type:'value',

            name:'Ha',

            max:2500,

            interval:500

        },

        series:[

            {

                name:'Target',

                type:'bar',

                data:[

                    40,
                    525,
                    170,
                    110,
                    100,
                    55,
                    40,
                    240,
                    2257,
                    150,
                    260,
                    125,
                    463,
                    20,
                    50,
                    50,
                    315,
                    10,
                    20

                ],

                barWidth:24,

                itemStyle:{
                    color:'#66B8E8',
                    borderRadius:[6,6,0,0]
                },

                label:{
                    show:true,
                    position:'top',
                    formatter:'{c}',
                    fontWeight:'600'
                }

            },

            {

                name:'Realisasi',

                type:'bar',

                data:[

                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    325,
                    0,
                    0,
                    0,
                    338,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0

                ],

                barWidth:24,

                itemStyle:{
                    color:'#25CF4A',
                    borderRadius:[6,6,0,0]
                },

                label:{
                    show:true,
                    position:'top',
                    formatter:function(params){

                        return params.value == 0 ? '' : params.value;

                    }
                }

            }

        ]

    };

    chart.setOption(option);

});

</script>
