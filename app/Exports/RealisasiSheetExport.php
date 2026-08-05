<?php

namespace App\Exports;

use App\Models\Realisasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RealisasiSheetExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithColumnWidths, WithColumnFormatting, WithEvents
{
    protected Request $request;

    // Instance property, bukan static -> aman dipakai berulang kali
    // (misal saat berjalan di queue worker / Octane yang me-reuse proses PHP)
    protected int $number = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;

        return Realisasi::query()
            ->with(['kegiatan', 'komoditas', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'satuan', 'direktorat'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($q2) use ($search) {
                    $q2->where('nama_kelompok', 'like', "%{$search}%")
                       ->orWhereHas('kegiatan', fn ($q3) => $q3->where('nama_kegiatan', 'like', "%{$search}%"))
                       ->orWhereHas('komoditas', fn ($q3) => $q3->where('nama', 'like', "%{$search}%"))
                       ->orWhereHas('provinsi', fn ($q3) => $q3->where('nama', 'like', "%{$search}%"))
                       ->orWhereHas('kabupaten', fn ($q3) => $q3->where('nama', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun', $request->tahun))
            ->when($request->filled('kegiatan_id'), fn ($q) => $q->where('kegiatan_id', $request->kegiatan_id))
            ->when($request->filled('komoditas_id'), fn ($q) => $q->where('komoditas_id', $request->komoditas_id))
            ->when($request->filled('provinsi_id'), fn ($q) => $q->where('provinsi_id', $request->provinsi_id))
            ->when($request->filled('kabupaten_id'), fn ($q) => $q->where('kabupaten_id', $request->kabupaten_id))
            ->when($request->filled('kecamatan_id'), fn ($q) => $q->where('kecamatan_id', $request->kecamatan_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('direktorat_id'), fn ($q) => $q->where('direktorat_id', $request->direktorat_id))
            ->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Direktorat',
            'Kegiatan',
            'Komoditas',
            'Kelompok Tani',
            'Desa',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Tahun',
            'Realisasi',
            'Satuan',
            'Anggaran',
            'Status',
        ];
    }

    public function map($item): array
    {
        $this->number++;

        return [
            $this->number,
            $item->direktorat?->nama,
            $item->kegiatan?->nama_kegiatan,
            $item->komoditas?->nama,
            $item->nama_kelompok,
            $item->desa?->nama,
            $item->kecamatan?->nama,
            $item->kabupaten?->nama,
            $item->provinsi?->nama,
            $item->tahun,
            $item->jumlah_output,
            $item->satuan?->nama,
            $item->anggaran,
            $item->status,
        ];
    }

    public function title(): string
    {
        return 'Realisasi';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 25,
            'C' => 40,
            'D' => 20,
            'E' => 25,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 10,
            'K' => 15,
            'L' => 15,
            'M' => 20,
            'N' => 18,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'J' => '0',                  // Tahun: angka biasa, tanpa pemisah ribuan
            'K' => '#,##0',              // Realisasi: pakai pemisah ribuan
            'M' => '"Rp" #,##0',         // Anggaran: format Rupiah
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn(); // N
                $highestRow = $sheet->getHighestRow();

                // Style header: fill hijau, font putih bold, rata tengah
                $headerRange = "A1:{$highestColumn}1";
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '2E7D32'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Border seluruh tabel (header + data)
                if ($highestRow >= 1) {
                    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'BFBFBF'],
                            ],
                        ],
                    ]);
                }

                // Kolom No rata tengah
                if ($highestRow >= 2) {
                    $sheet->getStyle("A2:A{$highestRow}")->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Freeze header agar tetap terlihat saat scroll, dan aktifkan autofilter
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:{$highestColumn}1");
            },
        ];
    }
}