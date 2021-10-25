<?php

namespace App\Imports;

use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TradeGoCashInRecord;
use App\ClientAyersAccount;

class TradeGoCashInImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    use Importable;

    public function model(array $row)
    {
        $ClientAyersAccount = ClientAyersAccount::where('account_no', $row['ccclnld'])->first();
        if (is_object($ClientAyersAccount)) {
            $row['uuid'] = $ClientAyersAccount->uuid;
            $bank_name = explode(" ", $row['bank_name']);
            $row['bank'] = $bank_name[0];
            $row['bank_account'] = $row['bank_acc_id'];
            $row['account_in'] = $row['ccclnld'];
            $row['amount'] = $row['amount'];
            $remark = explode(";", $row['remark']);
            $row['method'] = $remark[2];
            $row['status'] = 'pending';
        }
        return new TradeGoCashInRecord($row);
    }

    public function chunkSize(): int
    {
        return floor(65536 / count(TradeGoCashInRecord::getTableColumns()));
    }

    public function batchSize(): int
    {
        return floor(65536 / count(TradeGoCashInRecord::getTableColumns()));
    }
}
