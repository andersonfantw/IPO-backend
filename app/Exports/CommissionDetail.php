<?php

namespace App\Exports;

use App\TempClientBonusWithDummy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommissionDetail implements FromCollection, WithHeadings
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
            '產品代碼',
            '項目收入',
            'bonus_application',
            '項目成本',
            'ae_application_const',
            '帳戶累積收入',
            '13帳戶累積收入序號',
            '是否計算佣金',
            '獎金'
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
