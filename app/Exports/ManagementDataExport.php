<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ManagementDataExport implements WithMultipleSheets
{
    protected Request $request;

    public function __construct(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $this->request = $request;
    }

    public function sheets(): array
    {
        return [
            new TargetSheetExport($this->request),
            new RealisasiSheetExport($this->request),
        ];
    }
}