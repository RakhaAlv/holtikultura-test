@extends('layouts.app')

@section('title', 'Management Data')

@section('navbar-title')
Management Data
@endsection

@section('content')

<div class="space-y-5">

    @include('datamanagement.partials.header')

    @include('datamanagement.partials.tabs')

    <div id="management-content">

        Loading...

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    loadTarget();

});

function loadTarget(){

    fetch("{{ route('management.target') }}")
        .then(response => response.text())
        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

}

function loadRealisasi(){

    fetch("{{ route('management.realisasi') }}")
        .then(response => response.text())
        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

}

document.getElementById('btnTarget').addEventListener('click', function(){

    loadTarget();

});

document.getElementById('btnRealisasi').addEventListener('click', function(){

    loadRealisasi();

});


// ===============================
// MODAL TARGET
// ===============================

document.addEventListener('click', function(e){

    // buka modal
    if(e.target.closest('#btnTambahTarget')){

        const modal = document.getElementById('modalCreateTarget');

        if(modal){

            modal.classList.remove('hidden');
            modal.classList.add('flex');

        }

    }

    // tutup modal
    if(e.target.closest('#btnCloseTarget')){

        const modal = document.getElementById('modalCreateTarget');

        if(modal){

            modal.classList.remove('flex');
            modal.classList.add('hidden');

        }

    }

document.addEventListener("change", function(e){

    if(e.target.id === "provinsiSelect"){

        let provinsi = e.target.value;

        let kabupaten = document.getElementById("kabupatenSelect");

        if(!kabupaten) return;

        Array.from(kabupaten.options).forEach(function(option){

            if(option.value===""){
                option.hidden=false;
                return;
            }

            option.hidden = option.dataset.provinsi != provinsi;

        });

        kabupaten.value="";

    }

});

});

</script>

@endpush