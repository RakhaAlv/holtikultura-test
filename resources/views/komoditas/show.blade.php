@extends('layouts.app')

@section('title', $namaKomoditas)

@section('navbar-title', 'Rekap Komoditas : ' . $namaKomoditas)

@section('content')

<div class="space-y-7">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Target --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#64B5F6]"></div>

            <div class="flex items-center justify-between px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D8EEFF]">

                        <img
                            src="{{ asset('Icon-Target.svg') }}"
                            class="h-9 w-9">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Total Target
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                            {{ number_format($target,0,',','.') }}
                        </h2>

                        <p class="mt-1 text-[18px] text-[#555]">
                            Ha
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Realisasi --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#57D67A]"></div>

            <div class="flex items-center justify-between px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#CFF5DA]">

                        <img
                            src="{{ asset('Icon-Realisasi.svg') }}"
                            class="h-12 w-12">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Total Realisasi
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                            {{ number_format($realisasi,0,',','.') }}
                        </h2>

                        <p class="mt-1 text-[18px] text-[#555]">
                            Ha
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- Persentase --}}
        <div class="relative overflow-hidden rounded-[20px] bg-white shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#FFD54F]"></div>

            <div class="px-7 py-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#FFF5BF]">

                        <img
                            src="{{ asset('Icon-Persentase.svg') }}"
                            class="h-9 w-9">

                    </div>

                    <div>

                        <p class="text-[18px] font-semibold text-[#777]">
                            Persentase Capaian
                        </p>

                        <h2 class="mt-1 text-[44px] font-bold leading-none text-[#111]">
                            {{ $persentase }}%
                        </h2>

                    </div>

                </div>

                {{-- Progress --}}
                <div class="mt-6">

                    <div class="h-[8px] overflow-hidden rounded-full bg-[#D8D8D8]">

                        <div
                            class="h-full rounded-full bg-[#E83D5A]"
                            style="width: {{ $persentase }}%">
                        </div>

                    </div>

                </div>
                
            </div>

        </div>

    </div>

    {{-- Graph --}}

    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">

        <div class="mb-8 flex items-center gap-5">

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D8EEFF]">

                <img
                    src="{{ asset('Icon-Graph-Komoditas.svg') }}"
                    class="h-9 w-9">

            </div>

            <div>

                <h2 class="text-[34px] font-semibold text-[#1F2937]">

                    Grafik Capaian vs Target per Provinsi

                </h2>

                <p class="mt-1 text-[15px] text-[#7A7A7A]">

                    Perbandingan target dan realisasi Bawang Putih pada setiap provinsi.

                </p>

            </div>

        </div>

        <div
            id="provinsiChart"
            class="h-[520px] w-full">
        </div>

    </div>

    {{-- Filter Lokasi & Direktorat --}}
    <div class="rounded-[24px] bg-white p-7 shadow-[0_6px_18px_rgba(0,0,0,0.12)]">

        {{-- Header --}}
        <div class="mb-7 flex items-center gap-5">
    
          <div class="flex h-[62px] w-[62px] items-center justify-center rounded-2xl bg-[#A7F3C1]">

            <img
                src="{{ asset('Icon-Filter-Lokasi.svg') }}"
                class="h-12 w-12">

        </div>

        <h2 class="text-[34px] font-bold text-[#111827]">
            Filter Lokasi & Direktorat
        </h2>

    </div>


        {{-- Filter --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Provinsi --}}
            <div>

            <label class="mb-3 block text-[18px] font-semibold text-[#222]">
                Provinsi
            </label>

            <select
                class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] bg-white px-5 text-[18px] outline-none">

                <option>Semua Provinsi</option>

            </select>

        </div>

            {{-- Kabupaten --}}
            <div>

                <label class="mb-3 block text-[18px] font-semibold text-[#222]">
                    Kabupaten/Kota
                </label>

                <select
                    class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] bg-white px-5 text-[18px] outline-none">

                    <option>Semua Kabupaten/Kota</option>

                </select>

            </div>

            {{--Kecamatan --}}
            <div>

                <label class="mb-3 block text-[18px] font-semibold text-[#222]">
                    Kabupaten/Kota
                </label>

                <select
                    class="h-[58px] w-full rounded-[14px] border-2 border-[#2D2D2D] bg-white px-5 text-[18px] outline-none">

                    <option>Semua Kabupaten/Kota</option>

                </select>

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



@endsection