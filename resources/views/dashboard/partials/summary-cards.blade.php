

<div x-data="{ showAll: false }">

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        @foreach($summary as $commodity)

        <div
            
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