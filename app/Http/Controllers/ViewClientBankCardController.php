<?php

namespace App\Http\Controllers;

use App\ClientBankCard;
use Illuminate\Http\Request;

class ViewClientBankCardController extends HomeController
{
    protected $name = 'ViewClientBankCard';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $ClientBankCard = ClientBankCard::find($request->input('id'));
        if (is_object($ClientBankCard)) {
            $ClientBankCard->bankcard_blob = null;
            foreach ($ClientBankCard->getAttributes() as $key => $value) {
                $ClientBankCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientBankCardID'] = $ClientBankCard->id;
        $parameters['ClientBankCard'] = $ClientBankCard->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientBankCard->Client;

        $ClientIDCard = $Client->IDCard;
        if (is_object($ClientIDCard)) {
            $ClientIDCard->idcard_face = null;
            $ClientIDCard->idcard_back = null;
            foreach ($ClientIDCard->getAttributes() as $key => $value) {
                $ClientIDCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientIDCard'] = $ClientIDCard->toJson(JSON_UNESCAPED_UNICODE);

        if (is_object($Client)) {
            foreach ($Client->getAttributes() as $key => $value) {
                $Client->{$key} = addslashes($value);
            }
        }
        $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);

        return $parameters;
    }

    public function loadBankCard(Request $request)
    {
        $ClientBankCard = ClientBankCard::find($request->input('id'));
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }
}
