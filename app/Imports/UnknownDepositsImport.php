<?php
namespace App\Imports;

use App\Traits\Algorithm;
use App\UnknownDeposit;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UnknownDepositsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
{
    use Importable, Algorithm;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        try {
            $row['收入金額'] = preg_replace('/,/', '', $row['收入金額']);
            $row['支出金額'] = preg_replace('/,/', '', $row['支出金額']);
            $row['餘額'] = preg_replace('/,/', '', $row['餘額']);
            $row = array_map('trim', $row);
            $row = array_map(function ($value) {
                if (empty($value)) {
                    return null;
                } else {
                    return $value;
                }
            }, $row);
            if (!$row['收入金額']) {
                return null;
            }
            unset($row['序號']);
            unset($row['支出金額']);
            $row['transaction_date'] = $row['交易時間'];
            unset($row['交易時間']);
            $row['value_date'] = $row['起息日期'];
            unset($row['起息日期']);
            $row['type'] = $row['業務類型'];
            unset($row['業務類型']);
            $row['summary'] = $row['摘要'];
            unset($row['摘要']);
            $row['remark'] = $row['備註'];
            unset($row['備註']);

            $summary = $row['summary'];
            $remark = $row['remark'];
            $LCS = '';
            while ($this->LongestCommonSubstring($summary, $remark, $LCS) > 0) {
                $summary = str_replace($LCS, '', $summary);
                $remark = str_replace($LCS, '', $remark);
            }
            // do {
            //     $this->LongestCommonSubstring($summary, $remark, $LCS);
            //     $summary = str_replace($LCS, '', $summary);
            //     $remark = str_replace($LCS, '', $remark);
            // } while (!empty($LCS));

            preg_match("/CYSS[0-9a-zA-Z]{5}/i", $remark, $matches);
            $row['identification_code'] = empty($matches) ? null : $matches[0];
            $row['amount_in'] = $row['收入金額'];
            unset($row['收入金額']);
            $row['balance'] = $row['餘額'];
            unset($row['餘額']);
            $row['voucher_no'] = $row['憑證號'];
            unset($row['憑證號']);
            $row['account_no'] = $row['對方賬號'];
            unset($row['對方賬號']);
            $row['account_name'] = $row['對方戶名'];
            unset($row['對方戶名']);
            $row['trading_place'] = $row['交易場所'];
            unset($row['交易場所']);
            $row['uploaded_at'] = Carbon::today()->toDateString();
            // var_dump($row);
            return new UnknownDeposit($row);
        } catch (QueryException $e) {
            var_dump($e);
            return null;
        }
    }

    public function headingRow(): int
    {
        return 8;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return ['transaction_date', 'account_no', 'account_name', 'amount_in', 'balance'];
    }

}
