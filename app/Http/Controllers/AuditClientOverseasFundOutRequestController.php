<?php

namespace App\Http\Controllers;

use App\ClientOverseasFundOutRequest;
use Illuminate\Http\Request;

class AuditClientOverseasFundOutRequestController extends ViewClientOverseasFundOutRequestController
{
    protected $name = 'AuditClientOverseasFundOutRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientOverseasFundOutRequest = ClientOverseasFundOutRequest::find($input['id']);
        if ($request->has(['駁回信息'])) {
            $ClientOverseasFundOutRequest->status = 'rejected';
            $ClientOverseasFundOutRequest->remark = $input['駁回信息'];
        } else {
            $ClientOverseasFundOutRequest->status = 'approved';
            $ClientOverseasFundOutRequest->remark = null;
        }
        $ClientOverseasFundOutRequest->issued_by = auth()->user()->name;
        $ClientOverseasFundOutRequest->save();
        return redirect()->route('ClientOverseasFundOutRequests');
    }
}
