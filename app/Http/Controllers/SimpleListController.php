<?php

namespace App\Http\Controllers;

use App\ClientDepositProof;
use App\ViewClientIDCard;
use App\CysislbGtsClientAcc;
use App\AccountReport;
use App\Client;
use App\ClientBankCard;
use App\A01;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AccountReportFormRequest;
use Carbon\Carbon;

class SimpleListController extends Controller
{
    public function deposit()
    {
        return view('Table',
            [
                'data' => ClientDepositProof::leftJoin('view_client_idcard','client_deposit_proof.uuid','=','view_client_idcard.uuid')
                    ->leftJoin('client_bankcard','client_deposit_proof.uuid','=','client_bankcard.uuid')
                    ->select('name_c','name_en','client_deposit_proof.status','account_no','deposit_amount','deposit_bank','deposit_method','transfer_time','view_client_idcard.status as transfer_audit_status')
                    ->get()->toArray()
            ]
        );
    }

    public function MailList(){

        return view('Table', 
            [
                'data' => CysislbGtsClientAcc::select('client_acc_id','name','email')
                    ->whereIn('client_acc_id',AccountReport::ofParentID(20)->pluck('client_acc_id'))
                    ->get()->toArray()
            ]
        );
    }

    public function OpenStatus(){
        return view('Table', 
            [
                'data' => Client::select(
                        'name_c','name_en', 'nationality',
                        DB::raw("concat(concat(country_code,'-'),mobile) as mobile"), 
                        'progress', 'client.status', 
                        DB::raw("case length(selected_flow) when 14 then 15 when 15 then 16 when 40 then 19 when 37 then 15 end as total_steps"),
                        'client.created_at'
                    )->leftJoin('editable_steps','client.uuid','=','editable_steps.uuid')
                    ->leftJoin('view_client_idcard','client.uuid','=','view_client_idcard.uuid')
                    ->where('client.type','=','拼一手')
                    ->where('client.status','<>','audited2')
                    ->get()->toArray()
            ]
        );
    }

    public function BankcardRejected(){
        return view('Table', 
            [
                'data' => ClientBankCard::select('name_c','name_en','lcid','bank_name','bank_code','account_no','client_bankcard.status as bankcard_status')
                    ->leftJoin('view_client_idcard','view_client_idcard.uuid','=','client_bankcard.uuid')
                    ->whereIn('client_bankcard.uuid',Client::where('status','=','audited2')->pluck('uuid'))
                    ->where('client_bankcard.status','=','rejected')
                    ->get()->toArray()
            ]
        ); 
    }

    public function sms(){
        return View('SendSMS');
    }
    public function sendsms(Request $request){
        $input = $request->only('senderid','recipient','content');
        $content=$this->Text2Unicode($input['content']);
        $result = [];
        foreach(explode(',',$input['recipient']) as $recipient){
            $params = [
                'senderid' => $input['senderid'],
                'recipient' => $recipient,
                'content' => $content,
                'dos' => 'now',
                'username' => config('notification.Meteorsis.username'),
                'password'=> config('notification.Meteorsis.password'),
                'langeng' => 0
            ];
            $result = [$recipient => Http::get(config('notification.Meteorsis.url'), $params)];
        }
        return implode('<br />',$result);
    }
    protected function Text2Unicode($str): string
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
}
