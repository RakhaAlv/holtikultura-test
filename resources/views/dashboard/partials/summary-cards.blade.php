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
            x-show="showAll || {{ $index }} < 5"
            x-transition
            class="dashboard-card">

            {{-- Header --}}
            <div class="flex items-center justify-between">

                <h2 class="dashboard-card-title">
                    {{ $commodity['name'] }}
                </h2>

                <div class="dashboard-card-icon">

                    <img
                        src="{{ asset($commodity['icon']) }}"
                        class="h-15 w-15 object-contain">

                </div>

            </div>

            {{-- Target --}}
            <div class="mt-8">

                <p class="dashboard-card-label">
                    Target
                </p>

                <h3 class="dashboard-card-value">
                    {{ $commodity['target'] }}
                </h3>

            </div>

            {{-- Realisasi --}}
            <div class="mt-5">

                <p class="dashboard-card-label">
                    Realisasi
                </p>

                <h3 class="dashboard-card-value-success">
                    {{ $commodity['realisasi'] }}
                </h3>

            </div>

            {{-- Progress --}}
            <div class="mt-7">

                <div class="mb-2 flex justify-between text-sm">

                    <span class="dashboard-card-label">
                        Progress
                    </span>

                    <span class="font-semibold">
                        {{ $commodity['progress'] }}%
                    </span>

                </div>

                <div class="dashboard-progress">

                    <div
                        class="dashboard-progress-fill"
                        style="width: {{ $commodity['progress'] }}%">
                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>