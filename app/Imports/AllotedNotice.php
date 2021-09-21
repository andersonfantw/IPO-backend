<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AllotedNotice implements ToArray, WithHeadingRow, WithChunkReading
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function array(array $rows)
    {
        return $rows;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
