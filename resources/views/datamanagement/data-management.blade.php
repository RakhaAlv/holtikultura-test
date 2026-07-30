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

// ===============================
// LOAD HALAMAN
// ===============================

document.addEventListener('DOMContentLoaded', function () {

    loadTarget();

    document.getElementById('btnTarget').addEventListener('click', function () {

        loadTarget();

    });

    document.getElementById('btnRealisasi').addEventListener('click', function () {

        loadRealisasi();

    });

});


// ===============================
// AJAX TARGET
// ===============================

function loadTarget(){

    fetch("{{ route('management.target') }}")

        .then(response => response.text())

        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

}


// ===============================
// AJAX REALISASI
// ===============================

function loadRealisasi(){

    fetch("{{ route('management.realisasi') }}")

        .then(response => response.text())

        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

}


// ===============================
// FILTER TARGET (AJAX, submit & reset)
// ===============================

document.addEventListener('submit', function(e){

    if(e.target.id !== 'formFilterTarget') return;

    e.preventDefault();

    const params = new URLSearchParams(new FormData(e.target)).toString();

    fetch("{{ route('management.target') }}?" + params)

        .then(response => response.text())

        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

});

document.addEventListener('click', function(e){

    if(!e.target.closest('#btnResetFilterTarget')) return;

    loadTarget();

});


// ===============================
// PAGINATION (AJAX, bukan full reload)
// ===============================

document.addEventListener('click', function(e){

    const link = e.target.closest('#management-content .pagination a, #management-content nav a');

    if(!link) return;

    e.preventDefault();

    const url = link.getAttribute('href');

    if(!url) return;

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

        .then(response => response.text())

        .then(html => {

            document.getElementById('management-content').innerHTML = html;

        });

});


// ===============================
// MODAL CREATE / EDIT TARGET (open & close)
// ===============================

document.addEventListener('click', function(e){

    // Buka Modal (mode CREATE)
    if(e.target.closest('#btnTambahTarget')){

        resetFormTarget();

        const modal = document.getElementById('modalCreateTarget');

        if(modal){
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

    }

    // Tutup Modal
    if(e.target.closest('#btnCloseTarget')){

        const modal = document.getElementById('modalCreateTarget');

        if(modal){
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        resetFormTarget();

    }

});


// ===============================
// RESET FORM KE MODE CREATE
// ===============================

function resetFormTarget(){

    const form = document.getElementById('formTarget');

    if(!form) return;

    form.reset();

    document.getElementById('targetId').value = '';

    document.getElementById('methodField').innerHTML = '';

    document.getElementById('modalTitle').innerText = 'Tambah Target';

    form.action = "{{ route('management.target.store') }}";

    // reset kabupaten select ke default
    const kabupaten = document.getElementById('kabupatenSelect');
    if(kabupaten){
        kabupaten.innerHTML = `<option value="">Pilih Kabupaten</option>`;
    }
}


// ===============================
// AJAX PROVINSI -> KABUPATEN (untuk form create manual)
// ===============================

document.addEventListener('change', function(e){

    if(e.target.id !== 'provinsiSelect') return;

    const provinsiId = e.target.value;

    const kabupaten = document.getElementById('kabupatenSelect');

    if(!kabupaten) return;

    kabupaten.innerHTML = `
        <option value="">
            Memuat Kabupaten...
        </option>
    `;

    fetch("/dashboard/get-kabupaten?provinsi=" + provinsiId)

        .then(response => response.json())

        .then(data => {

            let html = `
                <option value="">
                    Pilih Kabupaten
                </option>
            `;

            data.forEach(function(item){

                html += `
                    <option value="${item.id}">
                        ${item.nama}
                    </option>
                `;

            });

            kabupaten.innerHTML = html;

        })

        .catch(function(){

            kabupaten.innerHTML = `
                <option value="">
                    Gagal memuat data
                </option>
            `;

        });

});


// ===============================
// EDIT TARGET
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('.btnEditTarget')) return;

    const id = e.target.closest('.btnEditTarget').dataset.id;

    fetch('/data-management/target/' + id)

        .then(response => response.json())

        .then(data => {

            resetFormTarget();

            // isi field dasar
            document.getElementById('targetId').value = data.id;
            document.getElementById('tahunField').value = data.tahun;
            document.getElementById('kegiatanField').value = data.kegiatan_id;
            document.getElementById('komoditasField').value = data.komoditas_id;
            document.getElementById('satuanField').value = data.satuan_id;
            document.getElementById('provinsiSelect').value = data.provinsi_id;
            document.getElementById('targetField').value = data.target;

            const direktoratField = document.getElementById('direktoratField');
            if(direktoratField){
                direktoratField.value = data.direktorat_id;
            }

            // load kabupaten sesuai provinsi, baru set value kabupaten
            const kabupatenSelect = document.getElementById('kabupatenSelect');

            fetch("/dashboard/get-kabupaten?provinsi=" + data.provinsi_id)

                .then(response => response.json())

                .then(list => {

                    let html = `<option value="">Pilih Kabupaten</option>`;

                    list.forEach(function(item){
                        html += `<option value="${item.id}">${item.nama}</option>`;
                    });

                    kabupatenSelect.innerHTML = html;
                    kabupatenSelect.value = data.kabupaten_id;

                });

            // ubah form jadi mode EDIT
            document.getElementById('modalTitle').innerText = 'Edit Target';

            document.getElementById('methodField').innerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('formTarget').action =
                "{{ route('management.target.update', ['target' => '__ID__']) }}"
                    .replace('__ID__', data.id);

            // tampilkan modal
            const modal = document.getElementById('modalCreateTarget');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

        })

        .catch(function(err){
            console.error('Gagal memuat data target:', err);
            alert('Gagal memuat data target untuk diedit.');
        });

});


// ===============================
// DELETE TARGET
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('.btnDeleteTarget')) return;

    const id = e.target.closest('.btnDeleteTarget').dataset.id;

    if(!confirm('Yakin ingin menghapus data target ini?')) return;

    fetch('/data-management/target/' + id, {

        method: 'DELETE',

        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }

    })

        .then(response => response.json())

        .then(data => {

            if(data.success){

                loadTarget();

            } else {

                alert('Gagal menghapus data.');

            }

        })

        .catch(function(err){

            console.error('Gagal menghapus target:', err);
            alert('Terjadi kesalahan saat menghapus data.');

        });

});

</script>

@endpush