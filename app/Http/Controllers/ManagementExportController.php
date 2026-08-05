<?php

namespace App\Http\Controllers;

use App\Exports\ManagementDataExport;
use App\Exports\TargetSheetExport;
use App\Exports\RealisasiSheetExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagementExportController extends Controller
{
    /**
     * Export gabungan (Target + Realisasi dalam 1 file, 2 sheet)
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $filename = 'data-management-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ManagementDataExport($request), $filename);
    }

    /**
     * Export Target saja
     */
    public function exportTarget(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $filename = 'target-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new TargetSheetExport($request), $filename);
    }

    /**
     * Export Realisasi saja
     */
    public function exportRealisasi(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $filename = 'realisasi-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new RealisasiSheetExport($request), $filename);
    }
}