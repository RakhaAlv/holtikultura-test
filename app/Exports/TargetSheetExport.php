<?php

namespace App\Exports;

use App\Models\Target;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TargetSheetExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithColumnWidths, WithStyles
{
    protected Request $request;

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
        static $no = 0;
        $no++;

        return [
            $no,
            $target->direktorat?->nama,
            $target->kegiatan?->nama_kegiatan,
            $target->kegiatan?->nama_rincian_output ?? $target->kegiatan?->nama_kegiatan,
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
            'A' => 8,
            'B' => 25,
            'C' => 40,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 12,
            'I' => 15,
            'J' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}