@php

$commodities = [

    [
        'name' => 'Bawang Putih',
        'icon' => 'Bawang-Putih-Card.svg',
        'target' => '1.250 Ha',
        'realisasi' => '1.020 Ha',
        'progress' => 82,
    ],

    [
        'name' => 'Bawang Merah',
        'icon' => 'Bawang-Merah-Card.svg',
        'target' => '1.980 Ha',
        'realisasi' => '1.610 Ha',
        'progress' => 81,
    ],

    [
        'name' => 'Cabai',
        'icon' => 'Cabai-Card.svg',
        'target' => '2.430 Ha',
        'realisasi' => '1.920 Ha',
        'progress' => 79,
    ],

    [
        'name' => 'Durian',
        'icon' => 'Durian-Card.svg',
        'target' => '845 Ha',
        'realisasi' => '700 Ha',
        'progress' => 83,
    ],

];

@endphp

<div x-data="{ showAll: false }">

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        @foreach($commodities as $index => $commodity)

        <div
            x-data="{
                editing:false,
                target:'{{ $commodity['target'] }}',
                realisasi:'{{ $commodity['realisasi'] }}'
            }"
            x-show="showAll || {{ $index }} < 5"
            x-transition
            class="rounded-3xl bg-white p-6 shadow-xl transition duration-300 hover:shadow-2xl">

            <!-- Header -->
        <div class="flex justify-between items-center">

            <!-- Judul -->
        <h2 class="text-xl font-semibold text-gray-800 leading-snug pt-6">
                {{ $commodity['name'] }}
        </h2>

            <!-- Edit + Icon -->
        <div class="flex flex-col items-end gap-2">

            <button
                @click="editing = !editing"
                class="rounded-lg p-1.5 transition hover:bg-gray-100">

                <img
                    src="{{ asset('Icon-Edit-Card.svg') }}"
                    class="h-5 w-5">

            </button>

            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#F3F8F4]">

                <img
                    src="{{ asset($commodity['icon']) }}"
                    class="h-15 w-15 object-contain">


             </div>

        </div>

</div>

            <!-- Target -->
            <p class="text-sm text-gray-500">
                Target
            </p>

            <div x-show="!editing">
                <h3 class="mt-1 text-2xl font-bold">
                    <span x-text="target"></span>
                </h3>
            </div>

            <div x-show="editing">

            <input
                x-model="target"
                class="mt-2 w-full rounded-lg border px-3 py-2">

                </div>
            <!-- Realisasi -->

            <p class="text-sm text-gray-500">
                Realisasi
            </p>

        <div x-show="!editing">

            <h3 class="mt-1 text-2xl font-bold text-[#2E7D32]">
                <span x-text="realisasi"></span>
            </h3>

</div>

        <div x-show="editing">

            <input
                x-model="realisasi"
                class="mt-2 w-full rounded-lg border px-3 py-2">

        </div>

        <div
            x-show="editing"
            class="mt-6 flex justify-end gap-3">

            <button
                 @click="editing=false"
                class="rounded-lg border px-4 py-2">

                Cancel

            </button>

            <button
                @click="editing=false"
                class="rounded-lg bg-[#16B33A] px-4 py-2 text-white">

                Save

            </button>

</div>

            <!-- Progress -->

            <div class="mt-7">

                <div class="mb-2 flex justify-between text-sm">

                    <span class="text-gray-500">

                        Progress

                    </span>

                    <span class="font-semibold">

                        {{ $commodity['progress'] }}%

                    </span>

                </div>

                <div class="h-3 rounded-full bg-gray-200">

                    <div
                        class="h-3 rounded-full bg-red-500"
                        style="width: {{ $commodity['progress'] }}%">

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    <!-- Show More -->

<div class="mt-6 flex justify-center">

    <button
        @click="showAll = !showAll"
        class="rounded-full bg-[#2E7D32] px-8 py-3 font-semibold text-white transition hover:bg-green-800">

        <span x-show="!showAll">
            Show More ▼
        </span>

        <span x-show="showAll">
            Show Less ▲
        </span>

    </button>

</div>

</div>