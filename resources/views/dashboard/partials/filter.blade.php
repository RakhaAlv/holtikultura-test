<form id="filterForm">
    <input type="hidden" name="tahun" value="{{ $tahun }}">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#C7F1CF]">

            <img 
                src="{{ asset('Icon-Filter-Lokasi.svg') }}"
                class="h-12 w-12">
  

        </div>

        <div>

            <h2 class="text-[20px] font-bold text-[#1F2937]">
                Filter Lokasi
            </h2>

            <p class="mt-1 text-[13px] text-[#7B7B7B]">
                Pilih wilayah untuk menampilkan data yang diinginkan.
            </p>

        </div>

    </div>

    {{-- Filter --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-10">

        {{-- Provinsi --}}
        <div class="lg:col-span-5">

            <label class="mb-2 block text-[14px] font-semibold text-[#222]">
                Provinsi
            </label>

            <select
                id="provinsiFilter"
                name="provinsi"
                class="h-[46px] w-full rounded-xl border border-[#D4D4D4] bg-white px-4 text-[15px] text-[#222] shadow-sm transition focus:border-[#16B33A] focus:outline-none">

                <option value="">
                    Semua Provinsi
                </option>

                @foreach($provinsis as $provinsi)

                    <option
                        value="{{ $provinsi->id }}"
                        {{ $provinsiId == $provinsi->id ? 'selected' : '' }}>

                        {{ $provinsi->nama }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Kabupaten --}}
        <div class="lg:col-span-5">

            <label class="mb-2 block text-[14px] font-semibold text-[#222]">
                Kabupaten/Kota
            </label>

            <select
                id="kabupatenFilter"
                name="kabupaten"
                class="h-[46px] w-full rounded-xl border border-[#D4D4D4] bg-white px-4 text-[15px] text-[#222] shadow-sm transition focus:border-[#16B33A] focus:outline-none">

                <option value="">
                    Semua Kabupaten/Kota
                </option>

                @foreach($kabupatens as $kabupaten)

                    <option
                        value="{{ $kabupaten->id }}"
                        {{ $kabupatenId == $kabupaten->id ? 'selected' : '' }}>

                        {{ $kabupaten->nama }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

<script>

const provinsi = document.getElementById('provinsiFilter');
const kabupaten = document.getElementById('kabupatenFilter');

async function loadTable() {

    const params = new URLSearchParams({

        tahun: "{{ $tahun }}",
        provinsi: provinsi.value,
        kabupaten: kabupaten.value

    });

    const response = await fetch("/dashboard/rekap-table?" + params);

    const html = await response.text();

    document.getElementById("rekapTable").innerHTML = html;
}

provinsi.addEventListener("change", async function () {

    const response = await fetch(
        "/dashboard/kabupaten?provinsi=" + this.value
    );

    const data = await response.json();

    kabupaten.innerHTML =
        '<option value="">Semua Kabupaten/Kota</option>';

    data.forEach(function(item){

        kabupaten.innerHTML +=
        `<option value="${item.id}">
            ${item.nama}
        </option>`;
    });

    loadTable();
});

kabupaten.addEventListener("change", loadTable);

</script>