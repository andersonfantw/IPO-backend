<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use Illuminate\Http\Request;

class AuditClientFundInRequestController extends ViewClientFundInRequestController
{
    protected $name = 'AuditClientFundInRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientFundInRequest = ClientFundInRequest::find($input['id']);
        $rejected = false;
        if ($request->has(['駁回信息']) && $request->filled(['駁回信息'])) {
            $ClientFundInRequest->status = 'rejected';
            $ClientFundInRequest->remark = $input['駁回信息'];
            $rejected = true;
        } else {
            $ClientFundInRequest->status = 'approved';
            $ClientFundInRequest->remark = null;
        }
        $ClientFundInRequest->issued_by = auth()->user()->name;
        $ClientFundInRequest->save();
        return redirect()->route($input['redirect_route']);
    }
}
