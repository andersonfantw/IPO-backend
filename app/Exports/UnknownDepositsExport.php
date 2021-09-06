<?php
namespace App\Exports;

use App\UnknownDeposit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnknownDepositsExport implements FromView
{
    private $Headers;
    private $uploaded_at;

    public function __construct($uploaded_at)
    {
        $this->uploaded_at = $uploaded_at;
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
            'status',
        ];
    }

    public function view(): View
    {
        $UnknownDeposits = UnknownDeposit::where('uploaded_at', $this->uploaded_at)->get();
        $Datas = [];
        foreach ($UnknownDeposits as $UnknownDeposit) {
            $Data = [
                '交易時間' => $UnknownDeposit->transaction_date,
                '起息日期' => $UnknownDeposit->value_date,
                '業務類型' => $UnknownDeposit->type,
                '摘要' => $UnknownDeposit->summary,
                '備註' => $UnknownDeposit->remark,
                '收入金額' => $UnknownDeposit->amount_in,
                '餘額' => $UnknownDeposit->balance,
                '憑證號' => $UnknownDeposit->voucher_no,
                '對方賬號' => $UnknownDeposit->account_no,
                '對方戶名' => $UnknownDeposit->account_name,
                '交易場所' => $UnknownDeposit->trading_place,
                'status' => $UnknownDeposit->status,
            ];
            $Datas[] = $Data;
        }
        return view('excel.UnknownDepositsExport', [
            'Headers' => $this->Headers,
            'Datas' => $Datas,
        ]);
    }

}
