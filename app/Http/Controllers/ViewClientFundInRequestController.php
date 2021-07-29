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
        $ClientFundInRequest = ClientFundInRequest::with(['Client', 'Client.ViewClientIDCard', 'Client.AyersAccounts'])
            ->find($input['id']);
        if (is_object($ClientFundInRequest)) {
            $ClientFundInRequest->receipt = null;
            $ClientFundInRequest->bankcard = null;
            $client_fund_in_request = [];
            foreach ($ClientFundInRequest->getAttributes() as $key => $value) {
                // $ClientFundInRequest->{$key} = addslashes($value);
                $client_fund_in_request[$key] = addslashes($value);
            }
            $parameters['Request_ID'] = $client_fund_in_request['id'];
            $parameters['Request'] = json_encode($client_fund_in_request, JSON_UNESCAPED_UNICODE);

            $Client = $ClientFundInRequest->Client;
            if (is_object($Client)) {
                $client = [];
                foreach ($Client->getAttributes() as $key => $value) {
                    // $Client->{$key} = addslashes($value);
                    $client[$key] = addslashes($value);
                }
                $parameters['Client'] = json_encode($client, JSON_UNESCAPED_UNICODE);

                $ClientIDCard = $Client->ViewClientIDCard;
                if (is_object($ClientIDCard)) {
                    $ClientIDCard->idcard_face = null;
                    $ClientIDCard->idcard_back = null;
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
            }
        }
        return $parameters;
    }
}
