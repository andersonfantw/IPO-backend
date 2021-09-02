<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnknownDepositsExport implements FromView
{
    private $Headers;

    public function __construct()
    {
        $this->Headers = [
            '交易時間',
            '起息日期',
            '業務類型',
            '摘要',
            '備註',
            '收入金額',
            '餘額',
            '憑證號',
            '對方賬號',
            '對方戶名',
            '交易場所',
        ];
    }

    public function view(): View
    {
        return view('excel.UnknownDepositsExport', [
            'Headers' => $this->Headers,
            'Datas' => [],
        ]);
    }

}
