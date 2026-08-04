@extends('layouts.app')

@section('title', 'Rekap Data Wilayah')

@section('navbar-title', 'Rekap Data Wilayah')

@section('content')

<div class="space-y-7">

    @include('rekapdata.partials.filter')

@include('rekapdata.partials.table', [
    'wilayahRows' => $wilayahRows
    ])

</div>

@endsection