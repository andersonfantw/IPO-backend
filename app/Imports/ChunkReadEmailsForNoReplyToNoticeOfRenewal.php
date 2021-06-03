<?php
namespace App\Imports;

use App\Mail\NoReplyToNoticeOfRenewal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Mail;

class ChunkReadEmailsForNoReplyToNoticeOfRenewal implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            dump($row);
            $name = $row[3];
            $email = $row[5];
            Mail::to($email, $name)->send(new NoReplyToNoticeOfRenewal);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
