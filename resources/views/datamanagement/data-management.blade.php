@extends('layouts.app')

@section('title', 'Management Data')

@section('navbar-title')
Management Data
@endsection

@section('content')

<div class="space-y-5">

    @include('datamanagement.partials.header')

    @include('datamanagement.partials.filter')

    @include('datamanagement.partials.table')

</div>

@endsection