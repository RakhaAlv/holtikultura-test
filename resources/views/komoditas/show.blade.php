
@extends('layouts.app')

@section('navbar-title','Rekap Komoditas : '. $komoditas->nama)

@section('content')
<div class="space-y-6">

    @include('komoditas.partials.cards')

    @include('komoditas.partials.chart')

    @include('komoditas.partials.filter')

    @include('komoditas.partials.table')

</div>
@endsection