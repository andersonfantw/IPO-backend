<?php
namespace App\Exports;

use App\ClientFundInRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientFundInRequestsExport2 extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['存款日期', '帳戶號碼', '英文名字', '存款金額', '入款銀行名稱', '銀行帳戶號碼', 'updated_at'];
        $ClientFundInRequests = ClientFundInRequest::where('status', 'approved')->get();
        $Requests = [];
        foreach ($ClientFundInRequests as $ClientFundInRequest) {
            $Request['存款日期'] = $ClientFundInRequest->updated_at->format('Y-m-d');
            $Request['帳戶號碼'] = $ClientFundInRequest->account_no;
            if ($ClientFundInRequest->Client->IDCard->name_en) {
                $Request['英文名字'] = $ClientFundInRequest->Client->IDCard->name_en;
            } else {
                $Request['英文名字'] = "{$ClientFundInRequest->Client->IDCard->surname} {$ClientFundInRequest->Client->IDCard->given_name}";
            }
            $Request['存款金額'] = number_format($ClientFundInRequest->amount, 2);
            $Request['入款銀行名稱'] = $ClientFundInRequest->bank;
            $Request['銀行帳戶號碼'] = "{$ClientFundInRequest->bank}:HKD:861-512-04226-1";
            $Request['updated_at'] = $ClientFundInRequest->updated_at;
            $Requests[] = $Request;
        }
        return view('excel.ClientFundInRequests', [
            'Headers' => $Headers,
            'ClientFundInRequests' => $Requests,
        ]);
    }
}
