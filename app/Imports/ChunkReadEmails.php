<?php
namespace App\Imports;

use App\Mail\Adhoc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Mail;

class ChunkReadEmails implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $found = false;
        foreach ($rows as $row) {
            if (!$found && $row[0] == '3115108') {
                $found = true;
                // continue;
            }
            if ($found) {
                dump($row);
                $name = $row[2];
                $email = $row[4];
                Mail::to($email, $name)->send(new Adhoc);
                sleep(5);
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
