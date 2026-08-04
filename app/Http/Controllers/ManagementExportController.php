<?php

namespace App\Http\Controllers;

use App\Exports\ManagementDataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagementExportController extends Controller
{
    public function export(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $filename = 'data-management-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ManagementDataExport($request), $filename);
    }
}