<?php

namespace App\Exports;

use App\ClientHKFundOutRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientHKFundOutRequestsExport extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
        $today = today()->toDateString();
        $ClientHKFundOutRequests = ClientHKFundOutRequest::where('status', 'approved')
            ->where('updated_at', 'like', "$today%")->get();
        $Requests = [];
        foreach ($ClientHKFundOutRequests as $ClientHKFundOutRequest) {
            $dt = $ClientHKFundOutRequest->updated_at;
            $Request['tran_date'] = "{$dt->day}/{$dt->month}/{$dt->year}";
            $Request['ccclnId'] = $ClientHKFundOutRequest->account_out;
            $Request['ccy'] = 'HKD';
            $Request['amount'] = $ClientHKFundOutRequest->amount * -1;
            $Request['remark'] = 'PRINCIPAL OUT';
            $Request['gl_mapping_item_id'] = null;
            $Request['bank_acc_id'] = "ICBC:HKD:861-512-04226-1";
            $Request['cheque'] = null;
            $Requests[] = $Request;
        }
        return view('excel.ClientHKFundOutRequests', [
            'Headers' => $Headers,
            'ClientHKFundOutRequests' => $Requests,
        ]);
    }
}
