<?php
namespace App\Traits;

use App\Exports\AyersDataExport;
use Excel as _Excel;

trait Excel
{
    public function exportAyersImportData(array $clients)
    {
        return _Excel::download(new AyersDataExport($clients), 'AyersImportData.xlsx');
    }

}
