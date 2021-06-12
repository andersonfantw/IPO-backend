<?php
namespace App\Imports;

use App\Models\A03;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class A03Import implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, WithUpserts
{
    use Importable;

    public function model(array $row)
    {
        return new A03($row);
    }

    public function batchSize(): int
    {
        return floor(65536 / count(A03::getTableColumns()));
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(A03::getTableColumns()));
    }

    public function uniqueBy(): array
    {
        return ['client_acc_id', 'product_id', 'buss_date'];
    }
}