<?php

namespace App\Http\Controllers;

use App\ClientHKFundOutRequest;
use Illuminate\Http\Request;

class AuditClientHKFundOutRequestController extends ViewClientHKFundOutRequestController
{
    protected $name = 'AuditClientHKFundOutRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientHKFundOutRequest = ClientHKFundOutRequest::find($input['id']);
        $rejected = false;
        if ($request->has(['駁回信息']) && $request->filled(['駁回信息'])) {
            $ClientHKFundOutRequest->status = 'rejected';
            $ClientHKFundOutRequest->remark = $input['駁回信息'];
            $rejected = true;
        } else {
            $ClientHKFundOutRequest->status = 'approved';
            $ClientHKFundOutRequest->remark = null;
        }
        $ClientHKFundOutRequest->issued_by = auth()->user()->name;
        $ClientHKFundOutRequest->save();
        return redirect()->route('ClientHKFundOutRequests');
    }
}
