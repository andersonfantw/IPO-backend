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
            $Request['tran_date'] = $ClientHKFundOutRequest->updated_at->format('D/M/Y');
            $Request['ccclnId'] = $ClientHKFundOutRequest->account_out;
            $Request['ccy'] = 'HKD';
            $Request['amount'] = number_format($ClientHKFundOutRequest->amount * -1, 2, '.', '');
            $Request['remark'] = 'PRINCIPAL OUT';
            $Request['gl_mapping_item_id'] = null;
            $Request['bank_acc_id'] = "ICBC:HKD:861-512-04226-1";
            $Request['cheque'] = null;
            $Requests[] = $Request;
        }
        dd($Requests);
        return view('excel.ClientHKFundOutRequests', [
            'Headers' => $Headers,
            'ClientHKFundOutRequests' => $Requests,
        ]);
    }
}
