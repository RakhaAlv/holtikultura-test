@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">


    {{-- Summary Cards --}}
    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
        @include('dashboard.partials.summary-cards')
    </div>

        {{-- Filter --}}
    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
        @include('dashboard.partials.filter')
    </div>

    {{-- Rekap Table --}}
    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
        <div id="rekapTable">
            @include('dashboard.partials.recap-table')
        </div>
    </div>

    {{-- Chart --}}
    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
        @include('dashboard.partials.chart')
    </div>

    {{-- Map --}}
    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
        @include('dashboard.partials.map')
    </div>

</div>

@endsection