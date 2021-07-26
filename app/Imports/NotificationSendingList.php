<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotificationSendingList implements ToArray, WithUpserts, WithHeadingRow
{
    use Importable;

    public function array(array $rows)
    {
        return $rows;
    }

    public function uniqueBy(): array
    {
        return [];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
