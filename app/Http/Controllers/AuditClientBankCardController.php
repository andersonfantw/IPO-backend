<?php

namespace App\Http\Controllers;

use App\ClientBankCard;
use App\RejectedClientBankcard;
use Illuminate\Http\Request;

class AuditClientBankCardController extends ViewClientBankCardController
{
    protected $name = 'AuditClientBankCard';

    public function audit(Request $request)
    {
        $ClientBankCard = ClientBankCard::where('account_no', $request->input('account_no'))->first();
        if (is_object($ClientBankCard)) {
            if ($request->has(['駁回信息'])) {
                RejectedClientBankcard::create([
                    'uuid' => $ClientBankCard->uuid,
                    'lcid' => $ClientBankCard->lcid,
                    'bank_name' => $ClientBankCard->bank_name,
                    'bank_code' => $ClientBankCard->bank_code,
                    'currency' => $ClientBankCard->currency,
                    'account_no' => $ClientBankCard->account_no,
                    'bankcard_blob' => $ClientBankCard->bankcard_blob,
                    'issued_by' => auth()->user()->name,
                    'remark' => $request->input('駁回信息'),
                ]);
                $ClientBankCard->delete();
            } else {
                $ClientBankCard->status = 'approved';
                $ClientBankCard->remark = null;
                $ClientBankCard->issued_by = auth()->user()->name;
                $ClientBankCard->save();
            }
        }
        return redirect()->route('ClientBankCards');
    }
}
