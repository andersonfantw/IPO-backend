<?php
namespace App\Exports;

use App\ClientHKFundOutRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientHKFundOutRequestsExport2 extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['提款日期', '帳戶號碼', '英文名字', '提款金額', '收款銀行名稱', '銀行帳戶號碼', 'updated_at'];
        $today = today()->toDateString();
        $ClientHKFundOutRequests = ClientHKFundOutRequest::where('status', 'approved')
            ->where('updated_at', 'like', "$today%")->get();
        $Requests = [];
        foreach ($ClientHKFundOutRequests as $ClientHKFundOutRequest) {
            $Request['提款日期'] = $ClientHKFundOutRequest->updated_at->format('Y-m-d');
            $Request['帳戶號碼'] = $ClientHKFundOutRequest->account_out;
            if ($ClientHKFundOutRequest->Client->IDCard->name_en) {
                $Request['英文名字'] = $ClientHKFundOutRequest->Client->IDCard->name_en;
            } else {
                $Request['英文名字'] = "{$ClientHKFundOutRequest->Client->IDCard->surname}{$ClientHKFundOutRequest->Client->IDCard->given_name}";
            }
            $Request['提款金額'] = $ClientHKFundOutRequest->amount;
            $Request['收款銀行名稱'] = $ClientHKFundOutRequest->bank;
            $Request['銀行帳戶號碼'] = $ClientHKFundOutRequest->account_in;
            $Request['updated_at'] = $ClientHKFundOutRequest->updated_at;
            $Requests[] = $Request;
        }
        return view('excel.ClientHKFundOutRequests', [
            'Headers' => $Headers,
            'ClientHKFundOutRequests' => $Requests,
        ]);
    }
}
