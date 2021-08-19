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
        (new NotifyService)->notify((new NotifyMessage)->mobile("$country_code$recipient")->templateId(8)->params(['uuid' => $Client->introducer_uuid]));
    }

    public function NoticeClientCorrectToRejectItemOn5days()
    {
        $EditableSteps = EditableSteps::leftJoin('client', 'editable_steps.uuid', '=', 'client.uuid')
            ->where('reason', '=', 'correction')
            ->groupBy('editable_steps.uuid')
            ->havingRaw('datediff(now(),min(editable_steps.created_at))=17')
            ->select('email', 'introducer_uuid')
            ->selectRaw('concat(client.country_code,client.mobile) as mobile')
            ->selectRaw('count(*) as Rejected')->get();
        foreach ($EditableSteps as $row) {
            (new NotifyService)->notify((new NotifyMessage)->mobile($row->mobile)->templateId(9)->params(['uuid' => $row->introducer_uuid]));
        }
    }

}
