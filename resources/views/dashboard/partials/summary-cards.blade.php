@php
    $count = count($summary);
@endphp

    {{-- Days 9 Progress --}}
    <div
        class="grid grid-cols-1 gap-6 md:grid-cols-2
    @if($count == 1)
        xl:grid-cols-1
    @elseif($count == 2)
        xl:grid-cols-2
    @elseif($count == 3)
        xl:grid-cols-3
    @else
        xl:grid-cols-4
    @endif
    ">

    @foreach($summary as $commodity)

    <div class="dashboard-card">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <h2 class="dashboard-card-title">
                {{ $commodity['name'] }}
            </h2>

            <img
                src="{{ asset($commodity['icon']) }}"
                class="h-14 w-14">

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

            <div class="flex justify-between mb-2">

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
                    style="width: {{ min($commodity['progress'],100) }}%">
                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>

