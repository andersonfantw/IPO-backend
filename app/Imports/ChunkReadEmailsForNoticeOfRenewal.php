<?php
namespace App\Imports;

use App\Mail\NoticeOfRenewal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Mail;

class ChunkReadEmailsForNoticeOfRenewal implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            dump($row);
            $name = $row[3];
            $email = $row[5];
            Mail::to($email, $name)->send(new NoticeOfRenewal);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
