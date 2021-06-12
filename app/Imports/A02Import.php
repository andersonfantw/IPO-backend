<?php
namespace App\Imports;

use App\Models\A02;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class A02Import implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, WithUpserts
{
    use Importable;

    public function model(array $row)
    {
        if(!is_numeric($row['client_id'])) return null;
        return new A02($row);
    }

    public function batchSize(): int
    {
        return floor(65536 / count(A02::getTableColumns()));
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(A02::getTableColumns()));
    }

    public function uniqueBy(): array
    {
        return ['client_id', 'open_date'];
    }
}