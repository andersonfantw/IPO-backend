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
        $ClientBankCard = ClientBankCard::find($input['account_no']);
        if (is_object($ClientBankCard)) {
            foreach ($ClientBankCard->getAttributes() as $key => $value) {
                if ($key == 'bankcard_blob') {
                    $ClientBankCard->{$key} = null;
                } else {
                    $ClientBankCard->{$key} = addslashes($value);
                }
            }
        }
        $parameters['ClientBankCard'] = $ClientBankCard->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientBankCard->Client;
        if (is_object($Client)) {
            foreach ($Client->getAttributes() as $key => $value) {
                $Client->{$key} = addslashes($value);
            }
        }
        $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);

        $ClientIDCard = $Client->ViewClientIDCard;
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
