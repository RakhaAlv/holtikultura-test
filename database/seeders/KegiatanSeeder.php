<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('kegiatans')->truncate();
        Schema::enableForeignKeyConstraints();

        $kegiatan = [
            ['id' => 1,  'kode_kegiatan' => '1771', 'nama_kegiatan' => 'Peningkatan Produksi Sayuran dan Tanaman Obat', 'kode_rincian_output' => '1771.QDD.011', 'nama_rincian_output' => 'Pekarangan Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,  'kode_kegiatan' => '1771', 'nama_kegiatan' => 'Peningkatan Produksi Sayuran dan Tanaman Obat', 'kode_rincian_output' => '1771.RAI.010', 'nama_rincian_output' => 'Kawasan Bawang Merah', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3,  'kode_kegiatan' => '1771', 'nama_kegiatan' => 'Peningkatan Produksi Sayuran dan Tanaman Obat', 'kode_rincian_output' => '1771.RAI.011', 'nama_rincian_output' => 'Kawasan Aneka Cabai', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4,  'kode_kegiatan' => '1771', 'nama_kegiatan' => 'Peningkatan Produksi Sayuran dan Tanaman Obat', 'kode_rincian_output' => '1771.RAI.014', 'nama_rincian_output' => 'Kawasan Bawang Putih', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5,  'kode_kegiatan' => '4581', 'nama_kegiatan' => 'Perbenihan Hortikultura', 'kode_rincian_output' => '4581.PDC.021', 'nama_rincian_output' => 'Sertifikat Tanda Daftar Varietas Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6,  'kode_kegiatan' => '4581', 'nama_kegiatan' => 'Perbenihan Hortikultura', 'kode_rincian_output' => '4581.QKB.011', 'nama_rincian_output' => 'Peredaran benih hortikultura yang diawasi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7,  'kode_kegiatan' => '4581', 'nama_kegiatan' => 'Perbenihan Hortikultura', 'kode_rincian_output' => '4581.RAI.010', 'nama_rincian_output' => 'Benih Sebar Umbi/Rimpang Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8,  'kode_kegiatan' => '4581', 'nama_kegiatan' => 'Perbenihan Hortikultura', 'kode_rincian_output' => '4581.RAI.011', 'nama_rincian_output' => 'Benih Sebar Batang Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9,  'kode_kegiatan' => '1773', 'nama_kegiatan' => 'Perlindungan Hortikultura', 'kode_rincian_output' => '1773.RAI.010', 'nama_rincian_output' => 'Area Pengendalian OPT Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'kode_kegiatan' => '1773', 'nama_kegiatan' => 'Perlindungan Hortikultura', 'kode_rincian_output' => '1773.RAI.013', 'nama_rincian_output' => 'Area Penanganan DPI Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'kode_kegiatan' => '1773', 'nama_kegiatan' => 'Perlindungan Hortikultura', 'kode_rincian_output' => '1773.RAI.014', 'nama_rincian_output' => 'Sarana Perlindungan Hortikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'kode_kegiatan' => '5886', 'nama_kegiatan' => 'Peningkatan Produksi Buah dan Florikultura', 'kode_rincian_output' => '5886.RAI.012', 'nama_rincian_output' => 'Kawasan Durian', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'kode_kegiatan' => '5886', 'nama_kegiatan' => 'Peningkatan Produksi Buah dan Florikultura', 'kode_rincian_output' => '5886.RAI.013', 'nama_rincian_output' => 'Kawasan Mangga', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'kode_kegiatan' => '5886', 'nama_kegiatan' => 'Peningkatan Produksi Buah dan Florikultura', 'kode_rincian_output' => '5886.RAI.014', 'nama_rincian_output' => 'Kawasan Salak', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'kode_kegiatan' => '5886', 'nama_kegiatan' => 'Peningkatan Produksi Buah dan Florikultura', 'kode_rincian_output' => '5886.RAI.015', 'nama_rincian_output' => 'Kawasan Anggur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'kode_kegiatan' => '5886', 'nama_kegiatan' => 'Peningkatan Produksi Buah dan Florikultura', 'kode_rincian_output' => '5886.RAI.016', 'nama_rincian_output' => 'Kawasan Jeruk', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kegiatans')->insert($kegiatan);
    }
}