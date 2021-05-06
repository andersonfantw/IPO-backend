<?php
namespace App\Traits;

use App\Exports\AyersDataExport;
use Excel as _Excel;
use Storage;

trait Excel
{
    public function exportAyersImportData(array $clients)
    {
        return _Excel::download(new AyersDataExport($clients), 'AyersImportData.xlsx');
    }
}
