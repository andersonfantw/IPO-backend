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
        // $Headers = ViewAyersImportData::first()->getAttributes();
        // $passport_ids = [];
        // foreach ($clients as $client) {
        //     $passport_ids[] = $client['證件號碼'];
        // }
        // $ViewAyersImportData = ViewAyersImportData::whereIn('passport_id', $passport_ids)->get();
        // $html = view('excel.AyersImportData', [
        //     'Headers' => $Headers,
        //     'AyersImportData' => $ViewAyersImportData,
        // ])->render();
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        // $spreadsheet = $reader->loadFromString($html);
        // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $path = storage_path('app/public/AyersImportData.xlsx');
        // $writer->save($path);
        // return Storage::disk('public')->download('AyersImportData.xlsx');
    }
}
