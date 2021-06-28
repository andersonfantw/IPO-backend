<?php

namespace App\Http\Controllers;

use App\ClientFundInternalTransferRequest;
use Illuminate\Http\Request;

class ViewClientFundInternalTransferRequestController extends HomeController
{
    protected $name = 'ViewClientFundInternalTransferRequest';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientFundInternalTransferRequest = ClientFundInternalTransferRequest::find($input['id']);
        if (is_object($ClientFundInternalTransferRequest)) {
            foreach ($ClientFundInternalTransferRequest->getAttributes() as $key => $value) {
                $ClientFundInternalTransferRequest->{$key} = addslashes($value);
            }
        }
        $parameters['Request'] = $ClientFundInternalTransferRequest->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientFundInternalTransferRequest->Client;
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
