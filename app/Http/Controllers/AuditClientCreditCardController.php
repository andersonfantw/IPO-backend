<?php

namespace App\Http\Controllers;

use App\ClientCreditCard;
use App\RejectedClientCreditCard;
use Illuminate\Http\Request;

class AuditClientCreditCardController extends ViewClientCreditCardController
{
    protected $name = 'AuditClientCreditCard';

    public function audit(Request $request)
    {
        $ClientCreditCard = ClientCreditCard::find($request->input('id'));
        if (is_object($ClientCreditCard)) {
            if ($request->has(['駁回信息'])) {
                RejectedClientCreditCard::create([
                    'uuid' => $ClientCreditCard->uuid,
                    'card_no' => $ClientCreditCard->card_no,
                    'owner_name' => $ClientCreditCard->owner_name,
                    'expiry_date' => $ClientCreditCard->expiry_date,
                    'card_issuer' => $ClientCreditCard->card_issuer,
                    'card_blob' => $ClientCreditCard->card_blob,
                    'issued_by' => auth()->user()->name,
                    'remark' => $request->input('駁回信息'),
                ]);
                $ClientCreditCard->delete();
            } else {
                $ClientCreditCard->status = 'approved';
                $ClientCreditCard->remark = null;
                $ClientCreditCard->issued_by = auth()->user()->name;
                $ClientCreditCard->save();
            }
        }
        return redirect()->route('ClientCreditCards');
    }
}
