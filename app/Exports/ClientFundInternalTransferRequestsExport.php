<?php
namespace App\Exports;

use App\ClientFundInternalTransferRequest;
use App\Exports\AyersValueBinder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

class ClientFundInternalTransferRequestsExport extends AyersValueBinder implements FromView
{
    public function view(): View
    {
        $Headers = ['tran_date', 'ccclnId', 'ccy', 'amount', 'remark', 'gl_mapping_item_id', 'bank_acc_id', 'cheque'];
        $ClientFundInternalTransferRequests = ClientFundInternalTransferRequest::where('status', 'approved')->get();
        $Requests = [];
        foreach ($ClientFundInternalTransferRequests as $ClientFundInternalTransferRequest) {
        }
    }
}