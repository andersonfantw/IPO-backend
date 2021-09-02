<?php

namespace App\Exports;

use App\TempClientBonusWithDummy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommissionDetail implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    private $data;
    public function __construct($data){
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            '項目',
            'AE代碼',
            '交易日',
            '交收日',
            '客戶帳號',
            '客戶姓名',
            '產品代碼',
            '項目收入',
            '項目成本',
            '帳戶累積收入',
            '13帳戶累積收入序號',
            '是否計算佣金',
            '獎金'
        ];
    }

    public function map($data):array
    {
        return [
            $data->cate,
            $data->ae_code,
            $data->buss_date,
            $data->allot_date,
            $data->client_acc_id,
            $data->name,
            $data->product_id,
            $data->application_fee,
            $data->application_cost,
            $data->accumulate_performance,
            $data->seq,
            $data->dummy,
            $data->bonus_application1,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
