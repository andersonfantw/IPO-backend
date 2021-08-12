<?php
namespace App\Traits;

use App;
use App\Client;
use App\EditableSteps;
use App\Services\NotifyMessage;
use App\Services\NotifyService;
use Illuminate\Support\Facades\Http;

trait SMS
{

    private function Text2Unicode($str)
    {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < ord('A')) {
                if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
                    $unicode[] = '00' . dechex($thisValue);
                } else {
                    $unicode[] = '00' . dechex($thisValue);
                }
            } else {
                if ($thisValue < 128) {
                    $unicode[] = '00' . dechex($thisValue);
                } else {
                    if (count($values) == 0) {
                        $lookingFor = ($thisValue < 224) ? 2 : 3;
                    }

                    $values[] = $thisValue;
                    if (count($values) == $lookingFor) {
                        $number = ($lookingFor == 3) ?
                        (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64) :
                        (($values[0] % 32) * 64) + ($values[1] % 64);
                        $number = dechex($number);
                        $unicode[] = (strlen($number) == 3) ? "0" . $number : "" . $number;
                        $values = array();
                        $lookingFor = 1;
                    }
                }
            }
        }
        for ($i = 0; $i < count($unicode); $i++) {
            $unicode[$i] = str_pad($unicode[$i], 4, "0", STR_PAD_LEFT);
        }
        return implode("", $unicode);
    }

    public function sendSMS(Client $Client, String $content)
    {
        $recipient = $Client->mobile;
        $country_code = config("locale.CountryCode.$Client->nationality");
        $response = Http::get(env('METEORSIS_API_URL'), [
            'langeng' => 0,
            'dos' => 'now',
            'senderid' => 'CYSS',
            'content' => $this->Text2Unicode($content),
            'recipient' => "$country_code$recipient",
            'username' => env('METEORSIS_ACCESS_KEY_ID'),
            'password' => env('METEORSIS_SECRET_ACCESS_KEY'),
        ]);
        return $response;
    }

    public function sendRejectionSMS(Client $Client)
    {
        $recipient = $Client->mobile;
        $country_code = config("locale.CountryCode.$Client->nationality");
        $introducer_uuid = $Client->introducer_uuid;

        $contents = <<<TEXT
【銀盛證券】尊敬的客戶，您開戶未能通過審核，請于5日内點擊以下鏈接(https://pys.chinayss.hk)登入開戶界面，並根據提示更新相應資料。感謝使用銀盛證券服務！
TEXT;

        (new NotifyService)->notify((new NotifyMessage)->mobile("$country_code$recipient")->content($contents));

        // $contents = [
        //     '[中國銀盛國際證券]',
        //     "閣下所提交的證券戶口開戶資料未能通過審核，請重新掃瞄二維碼（QR Code）或點擊以下開戶連結（https://pys.chinayss.hk）進入開戶流程，根據開戶流程中的指示修正或更新相應資料，所有資料修正完畢後頁面會跳到最後一個步驟，代表開戶資料已成功重新提交。謝謝您的耐心配合。",
        // ];
        // $content = implode("\n", $contents);
        // $response = Http::get(env('METEORSIS_API_URL'), [
        //     'langeng' => 0,
        //     'dos' => 'now',
        //     'senderid' => 'CYSS',
        //     'content' => $this->Text2Unicode($content),
        //     'recipient' => "$country_code$recipient",
        //     'username' => env('METEORSIS_ACCESS_KEY_ID'),
        //     'password' => env('METEORSIS_SECRET_ACCESS_KEY'),
        // ]);
        // return $response;
    }

    public function NoticeClientCorrectToRejectItemOn5days(){
        $EditableSteps = EditableSteps::leftJoin('client','editable_steps.uuid','=','client.uuid')
            ->where('reason','=','correction')
            ->groupBy('editable_steps.uuid')
            ->havingRaw('datediff(now(),min(es.created_at))=14')
            ->select('email')
            ->selectRaw('concat(editable_steps.country_code,editable_steps.mobile) as mobile')
            ->selectRaw('count(*) as Rejected')->get();
        foreach($EditableSteps as $row){
            //(new NotifyService)->notify((new NotifyMessage)->mobile($row->mobile)->templateId(9));
            (new NotifyService)->notify((new NotifyMessage)->mobile('85255984928')->templateId(9));
        }
    }

}
