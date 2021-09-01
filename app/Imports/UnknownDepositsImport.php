<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UnknownDepositsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        var_dump($row);
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

    public function rules(): array
    {
        return [
            '交易時間' => [
                // 'required',
                'date_format:Y-m-d H:i:s',
            ],
            '起息日期' => [
                // 'required',
                'date',
            ],
            '業務類型' => [
                // 'required',
                'string',
            ],
            '摘要' => [
                // 'required',
                'string',
            ],
            '備註' => [
                'string',
            ],
            '收入金額' => [
                'numeric',
            ],
            '支出金額' => [
                'numeric',
            ],
            '餘額' => [
                // 'required',
                'numeric',
            ],
            '憑證號' => [
                'string',
            ],
            '對方賬號' => [
                // 'required',
                'string',
            ],
            '對方戶名' => [
                // 'required',
                'string',
            ],
            '交易場所' => [
                'string',
            ],
        ];
    }
}
