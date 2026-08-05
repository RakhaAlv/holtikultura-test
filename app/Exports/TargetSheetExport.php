<?php

namespace App\Exports;

use App\Models\Target;
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

class TargetSheetExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithColumnWidths, WithColumnFormatting, WithEvents
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

        return Target::query()
            ->with(['kegiatan', 'komoditas', 'provinsi', 'kabupaten', 'satuan', 'direktorat'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($q2) use ($search) {
                    $q2->whereHas('kegiatan', function ($q3) use ($search) {
                            $q3->where('nama_kegiatan', 'like', "%{$search}%")
                               ->orWhere('nama_rincian_output', 'like', "%{$search}%");
                        })
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
            ->when($request->filled('direktorat_id'), fn ($q) => $q->where('direktorat_id', $request->direktorat_id))
            ->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Direktorat',
            'Kegiatan',
            'Rincian Output',
            'Komoditas',
            'Provinsi',
            'Kabupaten',
            'Tahun',
            'Target',
            'Satuan',
        ];
    }

    public function map($target): array
    {
        $this->number++;

        return [
            $this->number,
            $target->direktorat?->nama,
            $target->kegiatan?->nama_kegiatan,
            // Tidak lagi fallback ke nama_kegiatan supaya tidak duplikat dengan kolom Kegiatan
            $target->kegiatan?->nama_rincian_output ?? '-',
            $target->komoditas?->nama,
            $target->provinsi?->nama,
            $target->kabupaten?->nama,
            $target->tahun,
            $target->target,
            $target->satuan?->nama,
        ];
    }

    public function title(): string
    {
        return 'Target';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 25,
            'C' => 40,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 10,
            'I' => 16,
            'J' => 15,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '0',        // Tahun: angka biasa, tanpa pemisah ribuan
            'I' => '#,##0',    // Target: pakai pemisah ribuan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn(); // J
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