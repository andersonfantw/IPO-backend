<?php

namespace App\Http\Controllers;

use App\AE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use QrCode;

class AEController extends Controller
{
    public function create(Request $request)
    {
        $uuid = Str::uuid();
        $ae = AE::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => '王浩進',
            ]
        );
    }

    public function QRCode(Request $request)
    {
        $ae = AE::where('name', '王浩進')->first();
        return QrCode::size(250)->generate("http://192.168.2.102?introducer_uuid=$ae->uuid");
    }
}
