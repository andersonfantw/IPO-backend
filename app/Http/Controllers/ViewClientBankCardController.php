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
        $input = $request->all();
        $ClientBankCard = ClientBankCard::find($input['id']);
        $ClientBankCard->bankcard_blob = null;
        if (is_object($ClientBankCard)) {
            foreach ($ClientBankCard->getAttributes() as $key => $value) {
                $ClientBankCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientBankCardID'] = $ClientBankCard->id;
        $parameters['ClientBankCard'] = $ClientBankCard->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientBankCard->Client;
        if (is_object($Client)) {
            foreach ($Client->getAttributes() as $key => $value) {
                $Client->{$key} = addslashes($value);
            }
        }
        $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);

        $ClientIDCard = $Client->IDCard;
        $ClientIDCard->idcard_face = null;
        $ClientIDCard->idcard_back = null;
        if (is_object($ClientIDCard)) {
            foreach ($ClientIDCard->getAttributes() as $key => $value) {
                $ClientIDCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientIDCard'] = $ClientIDCard->toJson(JSON_UNESCAPED_UNICODE);

        return $parameters;
    }
}
