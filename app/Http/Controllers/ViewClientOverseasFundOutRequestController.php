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
        $ClientOverseasFundOutRequest = ClientOverseasFundOutRequest::with(['Client', 'Client.IDCard', 'Client.AyersAccounts'])
            ->find($request->input('id'));
        if (is_object($ClientOverseasFundOutRequest)) {
            $client_overseas_fund_out_request = [];
            foreach ($ClientOverseasFundOutRequest->getAttributes() as $key => $value) {
                // $ClientOverseasFundOutRequest->{$key} = addslashes($value);
                $client_overseas_fund_out_request[$key] = addslashes($value);
            }
            $parameters['Request'] = json_encode($client_overseas_fund_out_request, JSON_UNESCAPED_UNICODE);

            $Client = $ClientOverseasFundOutRequest->Client;
            if (is_object($Client)) {
                $client = [];
                foreach ($Client->getAttributes() as $key => $value) {
                    // $Client->{$key} = addslashes($value);
                    $client[$key] = addslashes($value);
                }
                $parameters['Client'] = json_encode($client, JSON_UNESCAPED_UNICODE);

                $ClientIDCard = $Client->IDCard;
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
