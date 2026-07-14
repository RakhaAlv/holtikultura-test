<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/kegiatan.csv'), 'r');
        fgetcsv($file);

        $mapDirektorat = [
            'perbenihan hortikultura' => 2,
            'perlindungan hortikultura' => 3,
            'peningkatan produksi sayuran dan tanaman obat' => 4,
            'buah dan florikultura' => 5, 
        ];

        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;

            $namaDirCsv = strtolower(trim($row[1]));
            $direktorat_id = $mapDirektorat[$namaDirCsv] ?? 1; // Default ke 1 (Sekretariat) jika teks tidak cocok

            $data[] = [
                'direktorat_id'      => $direktorat_id, // Kolom relasi utama ke tabel direktorat
                'kd_program'         => $row[2],
                'nama_program'       => $row[3],
                'kd_rincianoutput'   => $row[0],
                'nama_rincianoutput' => $row[1],
                'jenis_output'       => $row[4],
            ];
            
            if (count($data) >= 500) { 
                DB::table('kegiatan')->insert($data); 
                $data = []; 
            }
        }
        if (!empty($data)) DB::table('kegiatan')->insert($data);
        fclose($file);
    }
}