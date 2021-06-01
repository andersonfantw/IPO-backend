<?php

namespace App\Http\Controllers;

use App\ClientCreditCardFundOutRequest;
use Illuminate\Http\Request;

class AuditClientCreditCardFundOutRequestController extends ViewClientCreditCardFundOutRequestController
{
    protected $name = 'AuditClientCreditCardFundOutRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientCreditCardFundOutRequest = ClientCreditCardFundOutRequest::find($input['id']);
        $rejected = false;
        if ($request->filled(['駁回信息'])) {
            $ClientCreditCardFundOutRequest->status = 'rejected';
            $ClientCreditCardFundOutRequest->remark = $input['駁回信息'];
            $rejected = true;
        } else {
            $ClientCreditCardFundOutRequest->status = 'approved';
            $ClientCreditCardFundOutRequest->remark = null;
        }
        $ClientCreditCardFundOutRequest->issued_by = auth()->user()->name;
        $ClientCreditCardFundOutRequest->save();
        return redirect()->route('ClientCreditCardFundOutRequests');
    }
}
