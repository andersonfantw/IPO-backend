<?php
namespace App\Imports;

use App\A06;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class A06Import implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, WithUpserts
{
    use Importable;

    public function model(array $row)
    {
        return new A06($row);
    }

    public function batchSize(): int
    {
        return floor(65536 / count(A06::getTableColumns()));
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(A06::getTableColumns()));
    }

    public function uniqueBy(): array
    {
        return ['product_id', 'client_acc_id'];
    }
}