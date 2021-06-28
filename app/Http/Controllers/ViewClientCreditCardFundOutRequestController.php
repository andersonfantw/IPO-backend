<?php

namespace App\Http\Controllers;

use App\ClientCreditCardFundOutRequest;
use Illuminate\Http\Request;

class ViewClientCreditCardFundOutRequestController extends HomeController
{
    protected $name = 'ViewClientCreditCardFundOutRequest';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientCreditCardFundOutRequest = ClientCreditCardFundOutRequest::find($input['id']);
        if (is_object($ClientCreditCardFundOutRequest)) {
            foreach ($ClientCreditCardFundOutRequest->getAttributes() as $key => $value) {
                $ClientCreditCardFundOutRequest->{$key} = addslashes($value);
            }
        }
        $parameters['Request'] = $ClientCreditCardFundOutRequest->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientCreditCardFundOutRequest->Client;
        if (is_object($Client)) {
            foreach ($Client->getAttributes() as $key => $value) {
                $Client->{$key} = addslashes($value);
            }
        }
        $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);

        $ClientIDCard = $Client->ViewClientIDCard;
        $ClientIDCard->idcard_face = null;
        $ClientIDCard->idcard_back = null;
        if (is_object($ClientIDCard)) {
            foreach ($ClientIDCard->getAttributes() as $key => $value) {
                $ClientIDCard->{$key} = addslashes($value);
            }
        }
        $parameters['ClientIDCard'] = $ClientIDCard->toJson(JSON_UNESCAPED_UNICODE);

        $AyersAccounts = [];
        foreach ($Client->AyersAccounts as $AyersAccount) {
            $AyersAccount = $AyersAccount->attributesToArray();
            foreach ($AyersAccount as $key => $value) {
                $AyersAccount[$key] = addslashes($value);
            }
            $AyersAccounts[] = $AyersAccount;
        }
        $parameters['AyersAccounts'] = json_encode($AyersAccounts, JSON_UNESCAPED_UNICODE);
        return $parameters;
    }
}
