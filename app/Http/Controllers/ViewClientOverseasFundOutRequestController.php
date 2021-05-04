<?php

namespace App\Http\Controllers;

use App\ClientOverseasFundOutRequest;
use Illuminate\Http\Request;

class ViewClientOverseasFundOutRequestController extends HomeController
{
    protected $name = 'ViewClientOverseasFundOutRequest';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientOverseasFundOutRequest = ClientOverseasFundOutRequest::find($input['id']);
        if (is_object($ClientOverseasFundOutRequest)) {
            foreach ($ClientOverseasFundOutRequest->getAttributes() as $key => $value) {
                $ClientOverseasFundOutRequest->{$key} = addslashes($value);
            }
        }
        $parameters['Request'] = $ClientOverseasFundOutRequest->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientOverseasFundOutRequest->Client;
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
