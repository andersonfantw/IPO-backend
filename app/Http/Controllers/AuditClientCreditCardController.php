<?php

namespace App\Http\Controllers;

use App\ClientCreditCard;
use Illuminate\Http\Request;

class AuditClientCreditCardController extends ViewClientCreditCardController
{
    protected $name = 'AuditClientCreditCard';

    public function audit(Request $request)
    {
        $ClientCreditCard = ClientCreditCard::find($request->input('id'));
        if ($request->has(['駁回信息'])) {
            $ClientCreditCard->delete();
        } else {
            $ClientCreditCard->status = 'approved';
            $ClientCreditCard->remark = null;
            $ClientCreditCard->issued_by = auth()->user()->name;
            $ClientCreditCard->save();
        }
        return redirect()->route('ClientCreditCards');
    }
}
