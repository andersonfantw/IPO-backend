<?php

namespace App\Http\Controllers;

use App\ClientDepositProof;
use App\ViewClientIDCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AccountReportFormRequest;
use Carbon\Carbon;
class SimpleListController extends Controller
{
    public function deposit()
    {
        return ClientDepositProof::leftJoin('view_client_idcard','client_deposit_proof.uuid','=','view_client_idcard.uuid')->select('name_c','name_en','client_deposit_proof.status')->get();
    }
}
