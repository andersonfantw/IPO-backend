<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use Illuminate\Http\Request;

class AuditClientFundInRequestController extends Controller
{
    protected $name = 'AuditClientFundInRequest';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientFundInRequest = ClientFundInRequest::find($input['id']);
        if ($request->has(['駁回信息'])) {
            $ClientFundInRequest->status = 'rejected';
            $ClientFundInRequest->remark = $input['駁回信息'];
        } else {
            $ClientFundInRequest->status = 'approved';
            $ClientFundInRequest->remark = null;
        }
        $ClientFundInRequest->issued_by = auth()->user()->name;
        $ClientFundInRequest->save();
        return redirect()->route('ClientFundInRequests');
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
        $ClientFundInRequest = ClientFundInRequest::find($id);
        $ClientFundInRequest->status = $request->input('status');
        $ClientFundInRequest->issued_by = auth()->user()->name;
        $ClientFundInRequest->save();
    }
}
