<?php
namespace App\Imports;

use Carbon\Carbon;
use App\CysislProductInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class AProductInfoImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, WithUpserts, WithCustomCsvSettings
{
    use Importable;

    public function model(array $row)
    {
        if(substr(trim($row['listing_date']),0,1)=='/') $row['listing_date']=null;
        else $row['listing_date'] = Carbon::createFromFormat('m/d/Y H:i:s',$row['listing_date'])->toDateString();
        if(substr(trim($row['warrant_expiry_date']),0,1)=='/') $row['warrant_expiry_date']=null;
        else $row['warrant_expiry_date'] = Carbon::createFromFormat('m/d/Y H:i:s',$row['warrant_expiry_date'])->toDateString();
        return new CysislProductInfo($row);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'big5'
        ];
    }

    public function batchSize(): int
    {
        return floor(65536 / count(CysislProductInfo::getTableColumns()));
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(CysislProductInfo::getTableColumns()));
    }

    public function uniqueBy(): array
    {
        return ['product_code'];
    }
}
