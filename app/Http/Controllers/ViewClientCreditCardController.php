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
        $ClientCreditCard = ClientCreditCard::with(['Client', 'Client.IDCard'])
            ->find($request->input('id'));
        if (is_object($ClientCreditCard)) {
            $ClientCreditCard->card_blob = null;
            $client_credit_card = [];
            foreach ($ClientCreditCard->getAttributes() as $key => $value) {
                // $ClientCreditCard->{$key} = addslashes($value);
                $client_credit_card[$key] = addslashes($value);
            }
            $parameters['ClientCreditCardID'] = $client_credit_card['id'];
            $parameters['ClientCreditCard'] = json_encode($client_credit_card, JSON_UNESCAPED_UNICODE);

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
                $client = [];
                foreach ($Client->getAttributes() as $key => $value) {
                    // $Client->{$key} = addslashes($value);
                    $client[$key] = addslashes($value);
                }
                $parameters['Client'] = json_encode($client, JSON_UNESCAPED_UNICODE);
            }
        }
        return $parameters;
    }

    public function loadCreditCard(Request $request)
    {
        $ClientCreditCard = ClientCreditCard::find($request->input('id'));
        return response($ClientCreditCard->card_blob)->header('Content-Type', 'image/jpeg');
    }
}
