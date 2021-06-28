<?php

namespace App\Http\Controllers;

use App\ClientFundInRequest;
use Illuminate\Http\Request;

class ViewClientFundInRequestController extends HomeController
{
    protected $name = 'ViewClientFundInRequest';

    public function loadReceipt(Request $request)
    {
        $ClientFundInRequest = ClientFundInRequest::where('id', $request->input('id'))->first();
        return response($ClientFundInRequest->receipt)->header('Content-Type', 'image/png');
    }

    public function loadBankcard(Request $request)
    {
        $ClientFundInRequest = ClientFundInRequest::where('id', $request->input('id'))->first();
        return response($ClientFundInRequest->bankcard)->header('Content-Type', 'image/png');
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientFundInRequest = ClientFundInRequest::find($input['id']);
        if (is_object($ClientFundInRequest)) {
            foreach ($ClientFundInRequest->getAttributes() as $key => $value) {
                if ($key == 'receipt' || $key == 'bankcard') {
                    $ClientFundInRequest->{$key} = null;
                } else {
                    $ClientFundInRequest->{$key} = addslashes($value);
                }
            }
        }
        $parameters['Request_ID'] = $ClientFundInRequest->id;
        $parameters['Request'] = $ClientFundInRequest->toJson(JSON_UNESCAPED_UNICODE);

        $Client = $ClientFundInRequest->Client;
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
