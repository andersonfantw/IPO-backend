<?php

namespace App\Http\Controllers;

use App\ClientAddressProofUpdate;
use App\Traits\Image;
use Illuminate\Http\Request;

class ViewClientAddressProofUpdateController extends Controller
{
    use Image;

    protected $name = 'ViewClientAddressProofUpdate';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $ClientAddressProofUpdate = ClientAddressProofUpdate::find($request->input('id'));
        if (is_object($ClientAddressProofUpdate)) {
            $ClientAddressProofUpdate->image = null;
            foreach ($ClientAddressProofUpdate->getAttributes() as $key => $value) {
                $ClientAddressProofUpdate->{$key} = addslashes($value);
            }
            $parameters['AddressProofUpdateID'] = $ClientAddressProofUpdate->id;
            $parameters['ClientAddressProofUpdate'] = $ClientAddressProofUpdate->toJson(JSON_UNESCAPED_UNICODE);

            $Client = $ClientAddressProofUpdate->Client;
            foreach ($Client->getAttributes() as $key => $value) {
                $Client->{$key} = addslashes($value);
            }
            $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);

            $ClientIDCard = $Client->IDCard;
            $ClientIDCard->idcard_face = null;
            $ClientIDCard->idcard_back = null;
            foreach ($ClientIDCard->getAttributes() as $key => $value) {
                $ClientIDCard->{$key} = addslashes($value);
            }
            $parameters['ClientIDCard'] = $ClientIDCard->toJson(JSON_UNESCAPED_UNICODE);

            $ClientAddressProof = $Client->ClientAddressProof;
            $ClientAddressProof->image = null;
            foreach ($ClientAddressProof->getAttributes() as $key => $value) {
                $ClientAddressProof->{$key} = addslashes($value);
            }
            $parameters['AddressProofID'] = $ClientAddressProof->id;
            $parameters['ClientAddressProof'] = $ClientAddressProof->toJson(JSON_UNESCAPED_UNICODE);
            $parameters['redirect_route'] = $request->input('redirect_route');
            $parameters['action'] = $request->input('action');
        }
        return $parameters;
    }

    public function loadAddressProofUpdate(Request $request)
    {
        $ClientAddressProofUpdate = ClientAddressProofUpdate::find($request->input('id'));
        return response($ClientAddressProofUpdate->image)->header('Content-Type', 'image/jpeg');
    }

}
