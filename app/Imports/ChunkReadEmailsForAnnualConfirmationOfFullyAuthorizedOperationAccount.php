<?php
namespace App\Imports;

use App\Mail\AnnualConfirmationOfFullyAuthorizedOperationAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Mail;

class ChunkReadEmailsForAnnualConfirmationOfFullyAuthorizedOperationAccount implements ToCollection, WithChunkReading
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
            $name = $row[1];
            $email = $row[2];
            Mail::to($email, $name)->send(new AnnualConfirmationOfFullyAuthorizedOperationAccount);
            sleep(1);
            // }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
