<div>

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">

        <div>

            <h2 class="text-[28px] font-semibold text-[#1F2937]">
                Grafik Capaian Komoditas
            </h2>

            <p class="mt-2 text-[15px] text-[#7A7A7A]">
                Perbandingan target dan realisasi setiap komoditas
            </p>

        </div>

    </div>

    <!-- Chart -->
    <div
        id="commodityChart"
        class="h-[520px] w-full">
    </div>

</div>

<script>

//ECharts otomatis menyesuaikan ukurannya

window.addEventListener("load", function () {

    const chartDom = document.getElementById('commodityChart');

    const chart = echarts.init(chartDom);

    const observer = new ResizeObserver(() => {
    chart.resize();
    });

    // observe parent container chart
    observer.observe(chartDom.parentElement);

    const option = {

        animationDuration: 1000,

        grid:{
            top:40,
            left:60,
            right:20,
            bottom:80,
            containLabel:true
        },

        tooltip:{

            trigger:'axis',

                axisPointer:{
            type:'shadow'
        },

        formatter:function(params){

        let html = params[0].name + "<br>";

        params.forEach(item=>{

            html +=
                item.marker +
                " " +
                item.seriesName +
                ": <b>" +
                Number(item.value).toLocaleString('id-ID', {
                maximumFractionDigits: 0
                }) +
                " Ha</b><br>";

        });

        return html;

    },

    backgroundColor:'#fff',

    borderColor:'#E5E7EB',

    borderWidth:1,

    textStyle:{
        color:'#222'
    }

},

        

        legend:{

            bottom:20,

            itemWidth:18,

            itemHeight:18,

            textStyle:{
                fontSize:15,
                color:'#555'
            }

        },

        xAxis:{

            type:'category',

            axisTick:{
                show:false
            },

            axisLine:{
                lineStyle:{
                    color:'#D9D9D9'
                }
            },

            axisLabel:{
                margin:28,
                fontSize:15,
                color:'#555'
            },

            data: @json($chartData->pluck('komoditas'))

        },

        yAxis:{

    type:'value',

    min:0,

    axisLine:{
        show:false
    },

    axisTick:{
        show:false
    },

    axisLabel:{
    color:'#777',
    fontSize:14,
    formatter:function(value){
        return value.toLocaleString('id-ID');
    }
},

    splitLine:{
        lineStyle:{
            color:'#ECECEC'
        }
    }

},

        series:[

            {

                name:'Target',

                type:'bar',
                
                
                data: @json($chartData->pluck('target')),

                barWidth:50,

                barGap:'35%',

                barCategoryGap:'60%',

                label: {
                    show: true,
                    position: 'top',
                    color: '#6B7280',
                    fontSize: 13,
                    fontWeight: '600',
                    formatter: function(params) {
                    return Number(params.value).toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                    }) + ' Ha';
                }
                },


                itemStyle:{

                    color:'#7DC9F8',

                    borderRadius:[10,10,0,0]

                }

            },

            {

                name:'Realisasi',

                type:'bar',

                data: @json($chartData->pluck('realisasi')),

                barWidth:50,

                label: {
                    show: true,
                    position: 'top',
                    color: '#16B33A',
                    fontSize: 13,
                    fontWeight: '700',
                    formatter: function(params) {
                    return Number(params.value).toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                    }) + ' Ha';
                    }
                },

                itemStyle:{

                    color:'#27C74A',

                    borderRadius:[10,10,0,0]

                }

            }

        ]

    };

    //supaya kalau mini sidebar aktif dia mengikuti ukuran layar
    chart.setOption(option);

    setTimeout(() => {
        chart.resize();
    }, 300);

    setTimeout(() => {
        chart.resize();
    }, 600);

    window.addEventListener('resize', () => {

        chart.resize();

    });

});

</script>