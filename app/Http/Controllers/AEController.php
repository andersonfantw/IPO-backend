<?php

namespace App\Http\Controllers;

use App\AE;
use App\Salesman;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use QrCode;

class AEController extends Controller
{
    public function create(Request $request)
    {
        $uuid = Str::uuid();
        AE::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => 'Rebecca',
                'account_type' => '08',
                'code' => 'AELSH',
            ]
        );
        // AE::updateOrCreate(
        //     ['uuid' => $uuid],
        //     [
        //         'name' => 'Rebecca',
        //         'account_type' => '13',
        //         'code' => 'LSH01',
        //     ]
        // );
    }

    public function createStaff(Request $request)
    {
        $uuid = Str::uuid();
        Staff::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => '范焜華',
            ]
        );
    }

    public function createSalesman(Request $request)
    {
        $uuid = Str::uuid();
        Salesman::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => '量化簡財',
                'ae_uuid' => 'e550be72-fcb1-4779-980f-f255ff6eb041',
            ]
        );
    }

    public function generateQRCode(Request $request)
    {
        // $introducer = Staff::where('name', '范焜華')->first();
        // $introducer = Salesman::where('name', '量化簡財')->first();
        $introducer = AE::where('name', 'Rebecca')->first();
        return QrCode::format('png')->merge(public_path('images/ccyss-removebg-preview.png'), .3, true)->size(250)->generate("https://pys.chinayss.hk?introducer_uuid=$introducer->uuid");
    }

    public function QRCode(Request $request)
    {
        return view('QRCode');
    }
}
