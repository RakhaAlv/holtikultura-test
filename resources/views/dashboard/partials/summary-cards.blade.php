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