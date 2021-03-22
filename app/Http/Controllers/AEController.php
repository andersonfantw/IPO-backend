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

    public function generateQRCode(Request $request)
    {
        $ae = AE::where('name', '王浩進')->first();
        return QrCode::format('png')->merge(public_path('images/ccyss-removebg-preview.png'), .3, true)->size(250)->generate("https://pys.chinayss.hk?introducer_uuid=$ae->uuid");
    }

    public function QRCode(Request $request)
    {
        return view('QRCode');
    }
}
