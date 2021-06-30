<?php

namespace App\Http\Controllers;

use App\ClientHKFundOutRequest;
use Illuminate\Http\Request;

class ViewClientHKFundOutRequestController extends HomeController
{
    protected $name = 'ViewClientHKFundOutRequest';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientHKFundOutRequest = ClientHKFundOutRequest::find($input['id']);
        if (is_object($ClientHKFundOutRequest)) {
            foreach ($ClientHKFundOutRequest->getAttributes() as $key => $value) {
                $ClientHKFundOutRequest->{$key} = addslashes($value);
            }
        }
        $parameters['Request'] = $ClientHKFundOutRequest->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientHKFundOutRequest->Client;
        if (is_object($Client)) {
            foreach ($Client->getAttributes() as $key => $value) {
                if ($key == 'idcard_type') {
                    continue;
                }
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
