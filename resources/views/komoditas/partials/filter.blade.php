<div class="rounded-[18px] bg-white p-5 shadow-[0_6px_18px_rgba(0,0,0,0.08)]">

    {{-- Header --}}
    <div class="mb-5 flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#B8F0C6]">

            <img
                src="{{ asset('Icon-Filter-Lokasi.svg') }}"
                class="h-12 w-12">

        </div>

        <h2 class="text-[22px] font-bold text-[#111827]">
            Filter Lokasi & Direktorat
        </h2>

    </div>

    {{-- Filter --}}
    <form id="formFilterKomoditas" class="grid grid-cols-1 gap-5 lg:grid-cols-4">

        {{-- Provinsi --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Provinsi
            </label>

            <select
                id="provinsiSelectKomoditas"
                name="provinsi"
                class="h-[46px] w-full rounded-xl border border-[#D4D4D4] bg-white px-4 text-[15px] text-[#222] shadow-sm transition focus:border-[#16B33A] focus:outline-none">

                <option value="">Semua Provinsi</option>

                @foreach($provinsis as $item)
                    <option value="{{ $item->id }}" @selected($provinsiId == $item->id)>
                        {{ $item->nama }}
                    </option>
                @endforeach

            </select>

        </div>

        {{-- Kabupaten --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Kabupaten/Kota
            </label>

            <select
                id="kabupatenSelectKomoditas"
                name="kabupaten"
                class="h-[46px] w-full rounded-xl border border-[#D4D4D4] bg-white px-4 text-[15px] text-[#222] shadow-sm transition focus:border-[#16B33A] focus:outline-none">

                <option value="">Semua Kabupaten/Kota</option>

                @foreach($kabupatens as $item)
                    <option value="{{ $item->id }}" @selected($kabupatenId == $item->id)>
                        {{ $item->nama }}
                    </option>
                @endforeach

            </select>

        </div>

        {{-- Kecamatan --}}
        <div>

            <label class="mb-2 block text-[15px] font-semibold text-[#222]">
                Kecamatan
            </label>

            <select
                id="kecamatanSelectKomoditas"
                name="kecamatan"
                class="h-[46px] w-full rounded-xl border border-[#D4D4D4] bg-white px-4 text-[15px] text-[#222] shadow-sm transition focus:border-[#16B33A] focus:outline-none">

                <option value="">Semua Kecamatan</option>

                @foreach($kecamatans as $item)
                    <option value="{{ $item->id }}" @selected($kecamatanId == $item->id)>
                        {{ $item->nama }}
                    </option>
                @endforeach

            </select>

        </div>

        {{-- Tombol --}}
        <div>

            <label class="mb-2 block opacity-0">Action</label>

            <div class="flex h-[44px] gap-2">

                <button
                    type="button"
                    id="btnResetFilterKomoditas"
                    class="flex flex-1 items-center justify-center rounded-[10px] border border-[#D4D4D4] bg-white text-[15px] font-semibold text-[#222] transition hover:bg-gray-100">
                    Reset
                </button>

                <button
                    type="submit"
                    class="flex flex-1 items-center justify-center rounded-[10px] bg-[#15803D] text-[15px] font-semibold text-white transition hover:bg-[#166534]">
                    Filter
                </button>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>

// ===============================
// CASCADING: Provinsi -> Kabupaten -> Kecamatan
// (Reset dropdown di bawahnya saat dropdown atasnya berubah, lalu submit manual via tombol Filter)
// ===============================

document.addEventListener('change', function(e){

    if(e.target.id === 'provinsiSelectKomoditas'){

        const kabupaten = document.getElementById('kabupatenSelectKomoditas');
        const kecamatan = document.getElementById('kecamatanSelectKomoditas');

        kecamatan.innerHTML = `<option value="">Semua Kecamatan</option>`;

        if(!e.target.value){
            kabupaten.innerHTML = `<option value="">Semua Kabupaten/Kota</option>`;
            return;
        }

        kabupaten.innerHTML = `<option value="">Memuat...</option>`;

        fetch("{{ route('dashboard.getKabupaten') }}?provinsi=" + e.target.value)
            .then(response => response.json())
            .then(data => {
                let html = `<option value="">Semua Kabupaten/Kota</option>`;
                data.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                kabupaten.innerHTML = html;
            });

    }

    if(e.target.id === 'kabupatenSelectKomoditas'){

        const kecamatan = document.getElementById('kecamatanSelectKomoditas');

        if(!e.target.value){
            kecamatan.innerHTML = `<option value="">Semua Kecamatan</option>`;
            return;
        }

        kecamatan.innerHTML = `<option value="">Memuat...</option>`;

        fetch("{{ route('dashboard.getKecamatan') }}?kabupaten=" + e.target.value)
            .then(response => response.json())
            .then(data => {
                let html = `<option value="">Semua Kecamatan</option>`;
                data.forEach(item => html += `<option value="${item.id}">${item.nama}</option>`);
                kecamatan.innerHTML = html;
            });

    }

});


// ===============================
// RENDER ULANG TABEL (hasil AJAX) + re-init Alpine
// ===============================

function renderKomoditasTable(html){

    const oldEl = document.getElementById('komoditasTableWrapper');

    if(!oldEl) return;

    oldEl.outerHTML = html;

    const newEl = document.getElementById('komoditasTableWrapper');

    if(window.Alpine && newEl){
        window.Alpine.initTree(newEl);
    }

}


// ===============================
// SUBMIT FILTER (AJAX, hanya update tabel)
// ===============================

document.addEventListener('submit', function(e){

    if(e.target.id !== 'formFilterKomoditas') return;

    e.preventDefault();

    const params = new URLSearchParams(new FormData(e.target)).toString();

    const url = "{{ route('komoditas.show', $komoditas) }}" + (params ? '?' + params : '');

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            renderKomoditasTable(html);
        });

});


// ===============================
// RESET FILTER (AJAX, hanya update tabel)
// ===============================

document.addEventListener('click', function(e){

    if(!e.target.closest('#btnResetFilterKomoditas')) return;

    document.getElementById('provinsiSelectKomoditas').value = '';
    document.getElementById('kabupatenSelectKomoditas').innerHTML = `<option value="">Semua Kabupaten/Kota</option>`;
    document.getElementById('kecamatanSelectKomoditas').innerHTML = `<option value="">Semua Kecamatan</option>`;

    fetch("{{ route('komoditas.show', $komoditas) }}", {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            renderKomoditasTable(html);
        });

});

</script>
@endpush