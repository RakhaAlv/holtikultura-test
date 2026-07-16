@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            
    @include('dashboard.partials.summary-cards')

</div>

@endsection