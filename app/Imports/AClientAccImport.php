<?php
namespace App\Imports;

use App\CysislbGtsClientAcc;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class AClientAccImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, WithUpserts, WithCustomCsvSettings
{
    use Importable;

    public function model(array $row)
    {
        if(!is_numeric($row['client_acc_id'])) return null;
        if(trim($row['ors_investor_id'])=='') $row['ors_investor_id']=null;
        if(trim($row['disallow_buy'])=='') $row['disallow_buy']=null;
        if(trim($row['disallow_sell'])=='') $row['disallow_sell']=null;
        if(trim($row['margin_ratio'])=='') $row['margin_ratio']=null;
        return new CysislbGtsClientAcc($row);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'big5'
        ];
    }

    public function batchSize(): int
    {
        return floor(65536 / count(CysislbGtsClientAcc::getTableColumns()));
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(CysislbGtsClientAcc::getTableColumns()));
    }

    public function uniqueBy(): array
    {
        return ['client_acc_id'];
    }
}
