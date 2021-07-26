<?php

namespace App\Http\Controllers;

use App\ClientAddressProof;
use App\ClientAddressProofUpdate;
use Illuminate\Http\Request;

class AuditClientAddressProofUpdateController extends ViewClientAddressProofUpdateController
{
    protected $name = 'AuditClientAddressProofUpdate';

    public function audit(Request $request)
    {
        $ClientAddressProofUpdate = ClientAddressProofUpdate::find($request->input('id'));
        if (is_object($ClientAddressProofUpdate)) {
            if ($request->has(['駁回信息'])) {
                $ClientAddressProofUpdate->status = 'rejected';
                $ClientAddressProofUpdate->remark = $request->input('駁回信息');
                $ClientAddressProofUpdate->issued_by = auth()->user()->name;
                $ClientAddressProofUpdate->count_of_audits = $ClientAddressProofUpdate->count_of_audits + 1;
                $ClientAddressProofUpdate->save();
            } else {
                ClientAddressProof::where('uuid', $ClientAddressProofUpdate->uuid)
                    ->update([
                        'image' => $ClientAddressProofUpdate->image,
                        'detailed_address' => $ClientAddressProofUpdate->detailed_address,
                        'address_text' => $ClientAddressProofUpdate->address_text,
                    ]);
            }
        }
        return redirect()->route('ClientAddressProofUpdates');
    }
}
