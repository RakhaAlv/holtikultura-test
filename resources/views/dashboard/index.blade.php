@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    <!-- Summary Cards -->

    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            
        @include('dashboard.partials.summary-cards')

    </div>

    <!-- Recap Table -->

     <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">

          @include('dashboard.partials.recap-table')

    </div>

    <!-- Chart dashboard -->

     <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">

          @include('dashboard.partials.chart')

    </div>

    <!-- Map dashboard --> 

    <div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">

        @include('dashboard.partials.map')

    </div>
    
</div>


@endsection