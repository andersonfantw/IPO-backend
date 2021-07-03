<?php

namespace App\Http\Controllers;

use App\ClientBankCard;
use Illuminate\Http\Request;

class AuditClientBankCardController extends ViewClientBankCardController
{
    protected $name = 'AuditClientBankCard';

    public function audit(Request $request)
    {
        $ClientBankCard = ClientBankCard::where('account_no', $request->input('account_no'))->first();
        if ($request->has(['駁回信息'])) {
            // $ClientBankCard->status = 'rejected';
            // $ClientBankCard->remark = $input['駁回信息'];
            $ClientBankCard->delete();
        } else {
            $ClientBankCard->status = 'approved';
            $ClientBankCard->remark = null;
            $ClientBankCard->issued_by = auth()->user()->name;
            $ClientBankCard->save();
        }
        return redirect()->route('ClientBankCards');
    }
}
