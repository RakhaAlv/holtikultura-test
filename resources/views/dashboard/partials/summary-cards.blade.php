@php
    $count = count($summary);
@endphp

{{-- ================= Summary Cards ================= --}}
@if($count <= 4)

<div class="grid gap-8 py-3
    @if($count == 1)
        grid-cols-1
    @elseif($count == 2)
        grid-cols-2
    @elseif($count == 3)
        grid-cols-3
    @else
        grid-cols-4
    @endif">

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

        <div class="dashboard-card w-full">

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

@else

<div class="overflow-x-auto py-3">

    <div class="flex gap-8 min-w-max px-3">

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

            <div class="dashboard-card w-[240px] flex-shrink-0">

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

@endif

{{-- ================= Notes + Legend ================= --}}
<div class="mt-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

    {{-- Notes --}}
    <div class="flex-1 rounded-xl border border-[#D3D3D3] bg-[#D3D3D3] px-5 py-4">

        <div class="flex items-start gap-3">

            <img
                src="{{ asset('Icon-Tanda-Seru-Login.svg') }}"
                class="h-6 w-6 flex-shrink-0 mt-0.5"
                alt="Info">

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