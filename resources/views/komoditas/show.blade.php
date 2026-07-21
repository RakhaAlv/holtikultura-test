@extends('layouts.app')

@section('title', $namaKomoditas)

@section('navbar-title', 'Rekap Komoditas : '.$namaKomoditas)

@section('content')

<div class="space-y-7">

    @include('komoditas.partials.cards')

    @include('komoditas.partials.chart')

    @include('komoditas.partials.filter')

    @include('komoditas.partials.table')

</div>

@endsection