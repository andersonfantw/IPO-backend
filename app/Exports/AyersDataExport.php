<?php

namespace App\Exports;

use App\ViewAyersImportData;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AyersDataExport implements FromView
{
    // public function collection()
    // {
    //     return ViewAyersImportData::all();
    // }
    public function view(): View
    {
        $Headers = ViewAyersImportData::first()->getAttributes();
        return view('excel.AyersImportData', [
            'Headers' => $Headers,
            'AyersImportData' => ViewAyersImportData::all(),
        ]);
    }
}
