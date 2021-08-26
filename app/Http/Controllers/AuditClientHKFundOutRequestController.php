<?php

namespace App\Http\Controllers;

use App\ClientHKFundOutRequest;
use Illuminate\Http\Request;

class AuditClientHKFundOutRequestController extends Controller
{
    protected $name = 'AuditClientHKFundOutRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientHKFundOutRequest = ClientHKFundOutRequest::find($input['id']);
        if ($request->has(['駁回信息'])) {
            $ClientHKFundOutRequest->status = 'rejected';
            $ClientHKFundOutRequest->remark = $input['駁回信息'];
        } else {
            $ClientHKFundOutRequest->status = 'approved';
            $ClientHKFundOutRequest->remark = null;
        }
        $ClientHKFundOutRequest->issued_by = auth()->user()->name;
        $ClientHKFundOutRequest->save();
        return redirect()->route('ClientHKFundOutRequests');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ClientHKFundOutRequest = ClientHKFundOutRequest::find($id);
        $ClientHKFundOutRequest->status = $request->input('status');
        $ClientHKFundOutRequest->issued_by = auth()->user()->name;
        $ClientHKFundOutRequest->save();
    }
}
