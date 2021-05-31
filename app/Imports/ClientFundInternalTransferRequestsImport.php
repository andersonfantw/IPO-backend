<?php
namespace App\Imports;

use App\ClientFundInternalTransferRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientFundInternalTransferRequestsImport extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
        $ClientFundInternalTransferRequests = ClientFundInternalTransferRequest::where('status', 'approved')->get();
        $Requests = [];
        foreach ($ClientFundInternalTransferRequests as $ClientFundInternalTransferRequest) {
            $Request['tran_date'] = $ClientFundInternalTransferRequest->created_at->format('d/m/Y');
            $Request['ccclnId'] = $ClientFundInternalTransferRequest->account_in;
            $Request['ccy'] = 'HKD';
            $Request['amount'] = $ClientFundInternalTransferRequest->amount;
            $Request['remark'] = 'IN_CASH DEPOSIT';
            $Request['gl_mapping_item_id'] = null;
            $Request['bank_acc_id'] = "ICBC:HKD:861-512-04226-1";
            $Request['cheque'] = null;
            $Requests[] = $Request;
        }
        return view('excel.ClientFundInternalTransferRequests', [
            'Headers' => $Headers,
            'ClientFundInternalTransferRequests' => $Requests,
        ]);
    }
}
