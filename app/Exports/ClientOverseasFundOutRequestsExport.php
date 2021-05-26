<?php
namespace App\Exports;

use App\ClientOverseasFundOutRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientOverseasFundOutRequestsExport extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
        $ClientOverseasFundOutRequests = ClientOverseasFundOutRequest::where('status', 'approved')->get();
        $Requests = [];
        foreach ($ClientOverseasFundOutRequests as $ClientOverseasFundOutRequest) {
            $Request['tran_date'] = $ClientOverseasFundOutRequest->created_at->format('d/m/Y');
            $Request['ccclnId'] = $ClientOverseasFundOutRequest->account_out;
            $Request['ccy'] = 'HKD';
            $Request['amount'] = $ClientOverseasFundOutRequest->amount;
            $Request['remark'] = 'OUT_CASH WITHDRAWAL';
            $Request['gl_mapping_item_id'] = null;
            $Request['bank_acc_id'] = "ICBC:HKD:861-512-04226-1";
            $Request['cheque'] = null;
            $Requests[] = $Request;
        }
        return view('excel.ClientOverseasFundOutRequests', [
            'Headers' => $Headers,
            'ClientOverseasFundOutRequests' => $Requests,
        ]);
    }
}
