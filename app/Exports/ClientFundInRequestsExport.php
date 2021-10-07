<?php

namespace App\Exports;

use App\ClientFundInRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

class ClientFundInRequestsExport extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
        $ClientFundInRequests = ClientFundInRequest::where('status', 'approved')->get();
        $Requests = [];
        foreach ($ClientFundInRequests as $ClientFundInRequest) {
            $dt = Carbon::parse($ClientFundInRequest->transfer_time);
            $Request['tran_date'] = "{$dt->day}/{$dt->month}/{$dt->year}";
            $Request['ccclnId'] = $ClientFundInRequest->account_in;
            $Request['ccy'] = 'HKD';
            $Request['amount'] = $ClientFundInRequest->amount;
            $Request['remark'] = 'PRINCIPAL IN';
            $Request['gl_mapping_item_id'] = null;
            $Request['bank_acc_id'] = "$ClientFundInRequest->bank:HKD:$ClientFundInRequest->bank_account";
            $Request['cheque'] = null;
            $Requests[] = $Request;
        }
        return view('excel.ClientFundInRequests', [
            'Headers' => $Headers,
            'ClientFundInRequests' => $Requests,
        ]);
    }
}
