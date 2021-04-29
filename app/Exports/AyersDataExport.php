<?php
namespace App\Exports;

use App\Exports\AyersValueBinder;
use App\ViewAyersImportData;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AyersDataExport extends AyersValueBinder implements FromView
{

    private $clients;

    public function __construct(array $clients)
    {
        $this->clients = $clients;
    }

    public function view(): View
    {
        $Headers = ViewAyersImportData::first()->getAttributes();
        $passport_ids = [];
        foreach ($this->clients as $client) {
            $passport_ids[] = $client['證件號碼'];
        }
        $ViewAyersImportData = ViewAyersImportData::whereIn('passport_id', $passport_ids)->get();
        return view('excel.AyersImportData', [
            'Headers' => $Headers,
            'AyersImportData' => $ViewAyersImportData,
        ]);
    }
}
