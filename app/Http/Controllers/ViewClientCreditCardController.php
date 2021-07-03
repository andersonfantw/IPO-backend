<?php

namespace App\Http\Controllers;

use App\ClientCreditCard;
use Illuminate\Http\Request;

class ViewClientCreditCardController extends HomeController
{
    protected $name = 'ViewClientCreditCard';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $ClientCreditCard = ClientCreditCard::find($request->input('id'));
        if (is_object($ClientCreditCard)) {
            $ClientCreditCard->card_blob = null;
            foreach ($ClientCreditCard->getAttributes() as $key => $value) {
                $ClientCreditCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientCreditCardID'] = $ClientCreditCard->id;
        $parameters['ClientCreditCard'] = $ClientCreditCard->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientCreditCard->Client;

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

    public function loadCreditCard(Request $request)
    {
        $ClientCreditCard = ClientCreditCard::find($request->input('id'));
        return response($ClientCreditCard->card_blob)->header('Content-Type', 'image/jpeg');
    }
}
