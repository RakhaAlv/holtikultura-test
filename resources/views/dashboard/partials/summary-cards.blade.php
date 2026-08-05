@php
    $count = count($summary);
@endphp

{{-- ================= Summary Cards ================= --}}
<div class="overflow-x-auto p-3">

        <div
        class="grid gap-6 min-w-max
        @if($count == 1)
            grid-cols-1
        @elseif($count == 2)
            grid-cols-2
        @elseif($count == 3)
            grid-cols-3
        @elseif($count == 4)
            grid-cols-4
        @else
            grid-cols-5
        @endif
    ">

        @foreach($summary as $commodity)

            @php
                $progress = $commodity['progress'];

                if ($progress < 50) {
                    $progressColor = 'bg-red-500';
                } elseif ($progress < 75) {
                    $progressColor = 'bg-yellow-400';
                } else {
                    $progressColor = 'bg-green-500';
                }
            @endphp

            <div class="dashboard-card w-[240px]">

                {{-- Header --}}
                <div class="flex items-center justify-between">

                    <h2 class="dashboard-card-title">
                        {{ $commodity['name'] }}
                    </h2>

                    <img
                        src="{{ asset($commodity['icon']) }}"
                        class="h-20 w-20">

                </div>

                {{-- Target --}}
                <div class="mt-6">

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
                <div class="mt-6">

                    <div class="mb-2 flex justify-between">

                        <span class="dashboard-card-label">
                            Progress
                        </span>

                        <span class="font-semibold">
                            {{ $progress }}%
                        </span>

                    </div>

                    <div class="dashboard-progress">

                        <div
                            class="dashboard-progress-fill {{ $progressColor }}"
                            style="width: {{ min($progress,100) }}%">
                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- ================= Notes + Legend ================= --}}
<div class="mt-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

    {{-- Notes --}}
    <div class="flex-1 rounded-xl border border-[#D3D3D3] bg-[#D3D3D3] px-5 py-4">

        <div class="flex items-start gap-3">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 flex-shrink-0 text-black"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>

            </svg>

            <p class="text-sm font-medium text-black">

                <span class="font-bold">
                    Catatan:
                </span>

                Target output berdasarkan
                <strong>Rencana Kerja</strong>.

            </p>

        </div>

    </div>

    {{-- Legend --}}
    <div class="rounded-xl border border-gray-200 bg-white px-5 py-4 shadow-sm">

        <div class="mb-2 text-sm font-semibold text-gray-700">
            Progress
        </div>

        <div class="flex flex-wrap items-center gap-5 text-sm">

            <div class="flex items-center gap-2">
                <span class="h-3.5 w-3.5 rounded-full bg-red-500"></span>
                <span class="text-gray-600">
                    0–49%
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3.5 w-3.5 rounded-full bg-yellow-400"></span>
                <span class="text-gray-600">
                    50–74%
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3.5 w-3.5 rounded-full bg-green-500"></span>
                <span class="text-gray-600">
                    75–100%
                </span>
            </div>

        </div>

    </div>

</div>