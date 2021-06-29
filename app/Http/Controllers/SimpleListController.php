<?php

namespace App\Http\Controllers;

use App\ClientDepositProof;
use App\ViewClientIDCard;
use App\CysislbGtsClientAcc;
use App\AccountReport;
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
}
