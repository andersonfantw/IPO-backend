<?php

namespace App\Http\Controllers;

use App\ClientDepositProof;
use App\ViewClientIDCard;
use App\CysislbGtsClientAcc;
use App\AccountReport;
use App\Client;
use App\ClientBankCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    ->leftJoin('view_client_idcard','view_client_idcard.uuid','=','client_bankcard')
                    ->whereIn('uuid',Client::where('status','=','audited2')->pluck('uuid'))
                    ->get()->toArray()
            ]
        ); 
    }
}
