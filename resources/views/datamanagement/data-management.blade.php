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

            toggleTambahButton('target');

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

            toggleTambahButton('realisasi');

        });

}


// ===============================
// TOGGLE TOMBOL TAMBAH (Target / Realisasi)
// ===============================

function toggleTambahButton(active){

    const btnTarget = document.getElementById('btnTambahTarget');
    const btnRealisasi = document.getElementById('btnTambahRealisasi');

    if(!btnTarget || !btnRealisasi) return;

    if(active === 'target'){
        btnTarget.classList.remove('hidden');
        btnTarget.classList.add('flex');
        btnRealisasi.classList.remove('flex');
        btnRealisasi.classList.add('hidden');
    } else {
        btnRealisasi.classList.remove('hidden');
        btnRealisasi.classList.add('flex');
        btnTarget.classList.remove('flex');
        btnTarget.classList.add('hidden');
    }

}


// ===============================
// EXPORT EXCEL (ikut filter yang sedang aktif)
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('#btnExportExcel')) return;

    // Ambil filter dari form yang sedang aktif (Target atau Realisasi)
    const activeForm =
        document.getElementById('formFilterTarget') ||
        document.getElementById('formFilterRealisasi');

    let params = '';

    if(activeForm){
        params = new URLSearchParams(new FormData(activeForm)).toString();
    }

    const url = "{{ route('management.export') }}" + (params ? '?' + params : '');

    window.location.href = url;

});


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
// FILTER REALISASI
// ===============================

document.addEventListener('submit', function(e){

    if(e.target.id !== 'formFilterRealisasi') return;

    e.preventDefault();

    const params = new URLSearchParams(new FormData(e.target)).toString();

    fetch("{{ route('management.realisasi') }}?" + params)
        .then(response => response.text())
        .then(html => {
            document.getElementById('management-content').innerHTML = html;
        });

});

document.addEventListener('click', function(e){

    if(!e.target.closest('#btnResetFilterRealisasi')) return;

    loadRealisasi();

});


// ===============================
// MODAL CREATE / EDIT REALISASI (open & close)
// ===============================

document.addEventListener('click', function(e){

    if(e.target.closest('#btnTambahRealisasi')){

        resetFormRealisasi();

        const modal = document.getElementById('modalCreateRealisasi');
        if(modal){
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    if(e.target.closest('#btnCloseRealisasi')){

        const modal = document.getElementById('modalCreateRealisasi');
        if(modal){
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        resetFormRealisasi();
    }

});


// ===============================
// RESET FORM REALISASI KE MODE CREATE
// ===============================

function resetFormRealisasi(){

    const form = document.getElementById('formRealisasi');

    if(!form) return;

    form.reset();

    document.getElementById('realisasiId').value = '';
    document.getElementById('methodFieldRealisasi').innerHTML = '';
    document.getElementById('modalTitleRealisasi').innerText = 'Tambah Realisasi';
    form.action = "{{ route('management.realisasi.store') }}";

    ['kabupatenSelectR', 'kecamatanSelectR', 'desaSelectR'].forEach(function(id){
        const el = document.getElementById(id);
        if(el){
            const label = id === 'kabupatenSelectR' ? 'Kabupaten' : (id === 'kecamatanSelectR' ? 'Kecamatan' : 'Desa');
            el.innerHTML = `<option value="">Pilih ${label}</option>`;
        }
    });
}


// ===============================
// CASCADING WILAYAH (modal Realisasi)
// Asumsi endpoint tersedia: /dashboard/get-kabupaten?provinsi=
// dan endpoint serupa untuk kecamatan & desa.
// Sesuaikan URL berikut jika nama route Anda berbeda.
// ===============================

document.addEventListener('change', function(e){

    if(e.target.id === 'provinsiSelectR'){

        const kabupaten = document.getElementById('kabupatenSelectR');
        const kecamatan = document.getElementById('kecamatanSelectR');
        const desa = document.getElementById('desaSelectR');

        kecamatan.innerHTML = `<option value="">Pilih Kecamatan</option>`;
        desa.innerHTML = `<option value="">Pilih Desa</option>`;

        kabupaten.innerHTML = `<option value="">Memuat...</option>`;

        fetch("/dashboard/get-kabupaten?provinsi=" + e.target.value)
            .then(response => response.json())
            .then(data => {
                let html = `<option value="">Pilih Kabupaten</option>`;
                data.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                kabupaten.innerHTML = html;
            });
    }

    if(e.target.id === 'kabupatenSelectR'){

        const kecamatan = document.getElementById('kecamatanSelectR');
        const desa = document.getElementById('desaSelectR');

        desa.innerHTML = `<option value="">Pilih Desa</option>`;
        kecamatan.innerHTML = `<option value="">Memuat...</option>`;

        fetch("/dashboard/get-kecamatan?kabupaten=" + e.target.value)
            .then(response => response.json())
            .then(data => {
                let html = `<option value="">Pilih Kecamatan</option>`;
                data.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                kecamatan.innerHTML = html;
            });
    }

    if(e.target.id === 'kecamatanSelectR'){

        const desa = document.getElementById('desaSelectR');

        desa.innerHTML = `<option value="">Memuat...</option>`;

        fetch("/dashboard/get-desa?kecamatan=" + e.target.value)
            .then(response => response.json())
            .then(data => {
                let html = `<option value="">Pilih Desa</option>`;
                data.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                desa.innerHTML = html;
            });
    }

});


// ===============================
// EDIT REALISASI
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('.btnEditRealisasi')) return;

    const id = e.target.closest('.btnEditRealisasi').dataset.id;

    fetch('/data-management/realisasi/' + id)
        .then(response => response.json())
        .then(data => {

            resetFormRealisasi();

            document.getElementById('realisasiId').value = data.id;
            document.getElementById('tahunFieldR').value = data.tahun;
            document.getElementById('kegiatanFieldR').value = data.kegiatan_id;
            document.getElementById('komoditasFieldR').value = data.komoditas_id;
            document.getElementById('namaKelompokFieldR').value = data.nama_kelompok;
            document.getElementById('satuanFieldR').value = data.satuan_id;
            document.getElementById('jumlahOutputFieldR').value = data.jumlah_output;
            document.getElementById('anggaranFieldR').value = data.anggaran;
            document.getElementById('statusFieldR').value = data.status;
            document.getElementById('provinsiSelectR').value = data.provinsi_id;

            const direktoratField = document.getElementById('direktoratFieldR');
            if(direktoratField){
                direktoratField.value = data.direktorat_id;
            }

            const kabupatenSelect = document.getElementById('kabupatenSelectR');
            const kecamatanSelect = document.getElementById('kecamatanSelectR');
            const desaSelect = document.getElementById('desaSelectR');

            fetch("/dashboard/get-kabupaten?provinsi=" + data.provinsi_id)
                .then(response => response.json())
                .then(list => {
                    let html = `<option value="">Pilih Kabupaten</option>`;
                    list.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                    kabupatenSelect.innerHTML = html;
                    kabupatenSelect.value = data.kabupaten_id;

                    return fetch("/dashboard/get-kecamatan?kabupaten=" + data.kabupaten_id);
                })
                .then(response => response.json())
                .then(list => {
                    let html = `<option value="">Pilih Kecamatan</option>`;
                    list.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                    kecamatanSelect.innerHTML = html;
                    kecamatanSelect.value = data.kecamatan_id;

                    return fetch("/dashboard/get-desa?kecamatan=" + data.kecamatan_id);
                })
                .then(response => response.json())
                .then(list => {
                    let html = `<option value="">Pilih Desa</option>`;
                    list.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                    desaSelect.innerHTML = html;
                    desaSelect.value = data.desa_id;
                });

            document.getElementById('modalTitleRealisasi').innerText = 'Edit Realisasi';

            document.getElementById('methodFieldRealisasi').innerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('formRealisasi').action =
                "{{ route('management.realisasi.update', ['realisasi' => '__ID__']) }}"
                    .replace('__ID__', data.id);

            const modal = document.getElementById('modalCreateRealisasi');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

        })
        .catch(function(err){
            console.error('Gagal memuat data realisasi:', err);
            alert('Gagal memuat data realisasi untuk diedit.');
        });

});


// ===============================
// DELETE REALISASI
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('.btnDeleteRealisasi')) return;

    const id = e.target.closest('.btnDeleteRealisasi').dataset.id;

    if(!confirm('Yakin ingin menghapus data realisasi ini?')) return;

    fetch('/data-management/realisasi/' + id, {

        method: 'DELETE',

        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }

    })
        .then(response => response.json())
        .then(data => {

            if(data.success){
                loadRealisasi();
            } else {
                alert('Gagal menghapus data.');
            }

        })
        .catch(function(err){
            console.error('Gagal menghapus realisasi:', err);
            alert('Terjadi kesalahan saat menghapus data.');
        });

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