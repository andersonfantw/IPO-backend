<?php
namespace App\Traits;

use App\Client;
use App\ClientBankCard;
use Illuminate\Http\Request;

trait ImageLoader
{
    public function loadIDCardFace(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->IDCard->idcard_face)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_face}"));
    }

    public function loadIDCardBack(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->IDCard->idcard_back)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_back}"));
    }

    public function loadHKBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'zh-hk')->first();
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }

    public function loadCNBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'zh-cn')->first();
        if (is_object($ClientBankCard)) {
            return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
        } else {
            return null;
        }
    }

    public function loadOtherBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'others')->first();
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }

    public function loadBankCard(Request $request)
    {
        $ClientBankCard = ClientBankCard::find($request->input('id'));
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }

    public function loadNameCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientWorkingStatus->name_card_face)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientWorkingStatus->name_card_face}"));
    }

    public function loadSignature(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($this->base64ToBlob($Client->ClientSignature->image))->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientSignature->image}"));
    }

    public function loadDepositProof(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientDepositProof->image)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientDepositProof->image}"));
    }

    public function loadAddressProof(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientAddressProof->image)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientAddressProof->image}"));
    }
}
