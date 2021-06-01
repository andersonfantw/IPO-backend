<?php

namespace App\Http\Controllers;

use App\ClientBankCard;
use Illuminate\Http\Request;

class AuditClientBankCardController extends ViewClientBankCardController
{
    protected $name = 'AuditClientBankCard';

    public function audit(Request $request)
    {
        $input = $request->all();
        $ClientBankCard = ClientBankCard::find($input['account_no']);
        if ($request->filled(['駁回信息'])) {
            $ClientBankCard->status = 'rejected';
            $ClientBankCard->remark = $input['駁回信息'];
        } else {
            $ClientBankCard->status = 'approved';
            $ClientBankCard->remark = null;
        }
        $ClientBankCard->issued_by = auth()->user()->name;
        $ClientBankCard->save();
        return redirect()->route('ClientBankCards');
    }
}
