<?php

namespace App\Http\Controllers;

use App\ClientFundInternalTransferRequest;
use Illuminate\Http\Request;

class AuditClientFundInternalTransferRequestController extends ViewClientFundInternalTransferRequestController
{
    protected $name = 'AuditClientFundInternalTransferRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientFundInternalTransferRequest = ClientFundInternalTransferRequest::find($input['id']);
        if ($request->has(['駁回信息'])) {
            $ClientFundInternalTransferRequest->status = 'rejected';
            $ClientFundInternalTransferRequest->remark = $input['駁回信息'];
        } else {
            $ClientFundInternalTransferRequest->status = 'approved';
            $ClientFundInternalTransferRequest->remark = null;
        }
        $ClientFundInternalTransferRequest->issued_by = auth()->user()->name;
        $ClientFundInternalTransferRequest->save();
        return redirect()->route('ClientFundInternalTransferRequests');
    }
}
