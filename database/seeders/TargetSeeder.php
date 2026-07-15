<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Satuan;

class TargetSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/target.csv'), 'r');
        fgetcsv($file);

        $komoditasMap = DB::table('komoditas')->get()->mapWithKeys(fn($item) => [strtolower(trim($item->nama)) => $item->id])->toArray();
        $satuanMap = DB::table('satuan')->get()->mapWithKeys(fn($item) => [strtolower(trim($item->nama_satuan)) => $item->id])->toArray();
        $kegiatanDefault = DB::table('kegiatan')->first()->id ?? 1;

        $data = [];
        while (($row = fgetcsv($file, 0, ";")) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;

            $namaSatuan = strtolower(trim($row[8]));
            $namaKomoditas = strtolower(trim($row[2]));

            if (!isset($satuanMap[$namaSatuan])) {
                $newSatuan = DB::table('satuan')->insertGetId(['nama_satuan' => trim($row[8])]);
                $satuanMap[$namaSatuan] = $newSatuan;
            }

            $data[] = [
                'tahun'         => (int) $row[0],
                'kegiatan_id'   => $kegiatanDefault,
                'komoditas_id'  => $komoditasMap[$namaKomoditas] ?? 1,
                'satuan_id'     => $satuanMap[$namaSatuan],
                'provinsi_id'   => (int) $row[3],
                'kabupaten_id'  => (int) $row[4],
                'target_output' => (float) $row[7],
                'created_by'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
            
            if (count($data) >= 500) { DB::table('target')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('target')->insert($data);
        fclose($file);
    }
}