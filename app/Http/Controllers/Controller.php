<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Services\NotifyMessage;
use App\Services\NotifyService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user(Request $request)
    {
        return $request->user();
    }

    public function welcome(Request $request)
    {
        return view('welcome');
    }

    public function TestRoute(Request $request)
    {
        $route = $request->input('route');
        dd(config($route));
    }

//     public function testSendMsg(){
//         $contents =<<<TEXT
// [中國銀盛國際證券]
// 閣下所提交的證券戶口開戶資料未能通過審核，請重新掃瞄二維碼（QR Code）或點擊以下開戶連結（https://pys.chinayss.hk）進入開戶流程，根據開戶流程中的指示修正或更新相應資料，所有資料修正完畢後頁面會跳到最後一個步驟，代表開戶資料已成功重新提交。謝謝您的耐心配合。
// TEXT;
//         (new NotifyService)->notify(
//             (new NotifyMessage)->mobile('85255984928')->content($contents)
//         );
//         return ['ok'=>true];
//     }

//     public function testSendEmail(){
//         $contents =<<<TEXT
// [中國銀盛國際證券]
// 閣下所提交的證券戶口開戶資料未能通過審核，請重新掃瞄二維碼（QR Code）或點擊以下開戶連結（https://pys.chinayss.hk）進入開戶流程，根據開戶流程中的指示修正或更新相應資料，所有資料修正完畢後頁面會跳到最後一個步驟，代表開戶資料已成功重新提交。謝謝您的耐心配合。
// TEXT;
//         (new NotifyService)->notify(
//             (new NotifyMessage)->email('andersonfantw@gmail.com')->title('證券戶口開戶資料未能通過審核')->content($contents)
//         );
//         return ['ok'=>true];
//     }

//     public function testSendAccountOverview(){
//         $contents =<<<TEXT
// [中國銀盛國際證券]
// 閣下所提交的證券戶口開戶資料未能通過審核，請重新掃瞄二維碼（QR Code）或點擊以下開戶連結（https://pys.chinayss.hk）進入開戶流程，根據開戶流程中的指示修正或更新相應資料，所有資料修正完畢後頁面會跳到最後一個步驟，代表開戶資料已成功重新提交。謝謝您的耐心配合。
// TEXT;
//         (new NotifyService)->notify(
//             (new NotifyMessage)->clientId('200001')->title('證券戶口開戶資料未能通過審核')->content($contents)
//         );
//         return ['ok'=>true];
//     }
}
