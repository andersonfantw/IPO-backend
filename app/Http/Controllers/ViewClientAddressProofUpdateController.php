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
        }
        $parameters['ClientAddressProofUpdate'] = $ClientAddressProofUpdate->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

    public function loadAddressProofUpdate(Request $request)
    {
        $ClientAddressProofUpdate = ClientAddressProofUpdate::find($request->input('id'));
        return response($ClientAddressProofUpdate->image)->header('Content-Type', 'image/jpeg');
    }

}
