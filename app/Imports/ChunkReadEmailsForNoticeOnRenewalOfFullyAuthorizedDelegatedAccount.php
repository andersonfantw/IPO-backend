<?php
namespace App\Imports;

use App\Mail\NoticeOnRenewalOfFullyAuthorizedDelegatedAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Mail;

class ChunkReadEmailsForNoticeOnRenewalOfFullyAuthorizedDelegatedAccount implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        // $found = false;
        foreach ($rows as $row) {
            // if (!$found && $row[0] == '3876813') {
            //     $found = true;
            // }
            // if ($found) {
            dump($row);
            $name = $row[2];
            $email = $row[4];
            Mail::to($email, $name)->send(new NoticeOnRenewalOfFullyAuthorizedDelegatedAccount);
            sleep(1);
            // }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
