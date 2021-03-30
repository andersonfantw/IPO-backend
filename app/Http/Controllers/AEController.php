<?php

namespace App\Http\Controllers;

use App\AE;
use App\Staff;
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

    public function createStaff(Request $request)
    {
        $uuid = Str::uuid();
        Staff::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => '张冬梅',
            ]
        );
    }

    public function generateQRCode(Request $request)
    {
        $introducer = Staff::where('name', '张冬梅')->first();
        return QrCode::format('png')->merge(public_path('images/ccyss-removebg-preview.png'), .3, true)->size(250)->generate("https://pys.chinayss.hk?introducer_uuid=$introducer->uuid");
    }

    public function QRCode(Request $request)
    {
        return view('QRCode');
    }
}
