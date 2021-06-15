<?php

namespace App\Http\Controllers;

use App\Traits\Image;
use Illuminate\Http\Request;

class ViewClientAddressProofUpdateController extends Controller
{
    use Image;

    protected $name = 'ViewClientAddressProofUpdate';

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $ClientAddressProofUpdate = ClientAddressProofUpdate::find($input['uuid']);
        if (is_object($ClientAddressProofUpdate)) {
            foreach ($ClientAddressProofUpdate->getAttributes() as $key => $value) {
                if ($key == 'image') {
                    $ClientAddressProofUpdate->{$key} = $this->blobToBase64($value);
                } else {
                    $ClientAddressProofUpdate->{$key} = addslashes($value);
                }
            }
        }
        $parameters['ClientAddressProofUpdate'] = $ClientAddressProofUpdate->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }
}
