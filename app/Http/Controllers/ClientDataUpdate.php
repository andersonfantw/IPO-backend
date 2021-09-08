<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ClientAddressProof;
use App\ClientAddressProofUpdate;
use App\ClientBusinessType;
use App\ClientBusinessTypeUpdate;
use App\ClientCNIDCard;
use App\ClientCNIDCardUpdate;
use App\ClientHKIDCard;
use App\ClientHKIDCardUpdate;
use App\ClientOtherIDCard;
use App\ClientOtherIDCardUpdate;
use App\ClientFinancialStatus;
use App\ClientFinancialStatusUpdate;
use App\ClientInvestmentExperience;
use App\ClientInvestmentExperienceUpdate;
use App\ClientInvestmentOrientation;
use App\ClientInvestmentOrientationUpdate;
use App\ClientWorkingStatus;
use App\ClientWorkingStatusUpdate;
use App\ClientAyersAccount;

class ClientDataUpdate extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter=['client_id','name','mobile','email'];
        $input = $request->only($filter);
        $query = DB::query()->fromSub(
            DB::query()->fromSub(
                ClientAddressProofUpdate::leftJoin('client_address_proof','client_address_proof_updates.uuid','=','client_address_proof.uuid')
                ->select('client_address_proof_updates.id','client_address_proof_updates.uuid','client_address_proof_updates.created_at')->selectRaw("'ClientAddressProofUpdate' as model")
                ->selectRaw("json_object('address_text',client_address_proof_updates.address_text) as updating")
                ->selectRaw("json_object('address_text',client_address_proof.address_text) as original")
                ->where('client_address_proof_updates.status','=','pending')
                ->union(ClientBusinessTypeUpdate::leftJoin('client_business_type','client_business_type_updates.uuid','=','client_business_type.uuid')
                    ->select('client_business_type_updates.id','client_business_type_updates.uuid','client_business_type_updates.created_at')->selectRaw("'ClientBusinessTypeUpdate' as model")
                    ->selectRaw("json_object('business_type',client_business_type_updates.business_type,'agree_direct_promotion',client_business_type_updates.agree_direct_promotion,'direct_promotion',client_business_type_updates.direct_promotion) as updating")
                    ->selectRaw("json_object('business_type',client_business_type.business_type,'agree_direct_promotion',client_business_type.agree_direct_promotion,'direct_promotion',client_business_type.direct_promotion) as original")
                    ->where('client_business_type_updates.status','=','pending')
                )->union(ClientCNIDCardUpdate::leftJoin('client_cn_idcard','client_cn_idcard_updates.uuid','=','client_cn_idcard.uuid')
                    ->select('client_cn_idcard_updates.id','client_cn_idcard_updates.uuid','client_cn_idcard_updates.created_at')->selectRaw("'ClientCNIDCardUpdate' as model")
                    ->selectRaw("json_object('type',client_cn_idcard_updates.type,'nationality',client_cn_idcard_updates.nationality,'gender',client_cn_idcard_updates.gender,'birthday',client_cn_idcard_updates.birthday,'name_c',client_cn_idcard_updates.name_c,'surname',client_cn_idcard_updates.surname,'given_name',client_cn_idcard_updates.given_name,'idcard_no',client_cn_idcard_updates.idcard_no,'idcard_address',client_cn_idcard_updates.idcard_address,'issued_by',client_cn_idcard_updates.issued_by,'valid_date',client_cn_idcard_updates.valid_date) as updating")
                    ->selectRaw("json_object('type',client_cn_idcard.type,'nationality',client_cn_idcard.nationality,'gender',client_cn_idcard.gender,'birthday',client_cn_idcard.birthday,'name_c',client_cn_idcard.name_c,'surname',client_cn_idcard.surname,'given_name',client_cn_idcard.given_name,'idcard_no',client_cn_idcard.idcard_no,'idcard_address',client_cn_idcard.idcard_address,'issued_by',client_cn_idcard.issued_by,'valid_date',client_cn_idcard.valid_date) as original")
                    ->where('client_cn_idcard_updates.status','=','pending')
                )->union(ClientHKIDCardUpdate::leftJoin('client_hk_idcard','client_hk_idcard_updates.uuid','=','client_hk_idcard.uuid')
                    ->select('client_hk_idcard_updates.id','client_hk_idcard_updates.uuid','client_hk_idcard_updates.created_at')->selectRaw("'ClientHKIDCardUpdate' as model")
                    ->selectRaw("json_object('type',client_hk_idcard_updates.type,'name_c',client_hk_idcard_updates.name_c,'name_en',client_hk_idcard_updates.name_en,'gender',client_hk_idcard_updates.gender,'birthday',client_hk_idcard_updates.birthday,'idcard_no',client_hk_idcard_updates.idcard_no) as updating")
                    ->selectRaw("json_object('type',client_hk_idcard.type,'name_c',client_hk_idcard.name_c,'name_en',client_hk_idcard.name_en,'gender',client_hk_idcard.gender,'birthday',client_hk_idcard.birthday,'idcard_no',client_hk_idcard.idcard_no) as original")
                    ->where('client_hk_idcard_updates.status','=','pending')
                )->union(ClientOtherIDcardUpdate::leftJoin('client_other_idcard','client_other_idcard_updates.uuid','=','client_other_idcard.uuid')
                    ->select('client_other_idcard_updates.id','client_other_idcard_updates.uuid','client_other_idcard_updates.created_at')->selectRaw("'ClientOtherIDcardUpdate' as model")
                    ->selectRaw("json_object('type',client_other_idcard_updates.type,'name_c',client_other_idcard_updates.name_c,'name_en',client_other_idcard_updates.name_en,'gender',client_other_idcard_updates.gender,'birthday',client_other_idcard_updates.birthday,'idcard_no',client_other_idcard_updates.idcard_no) as updating")
                    ->selectRaw("json_object('type',client_other_idcard.type,'name_c',client_other_idcard.name_c,'name_en',client_other_idcard.name_en,'gender',client_other_idcard.gender,'birthday',client_other_idcard.birthday,'idcard_no',client_other_idcard.idcard_no) as original")
                    ->where('client_other_idcard_updates.status','=','pending')
                )->union(ClientFinancialStatusUpdate::leftJoin('client_financial_status','client_financial_status_updates.uuid','=','client_financial_status.uuid')
                    ->select('client_financial_status_updates.id','client_financial_status_updates.uuid','client_financial_status_updates.created_at')->selectRaw("'ClientFinancialStatusUpdate' as model")
                    ->selectRaw("json_object('fund_source',client_financial_status_updates.fund_source,'other_fund_source',client_financial_status_updates.other_fund_source,'income',client_financial_status_updates.annual_income,'net',client_financial_status_updates.net_assets) as updating")
                    ->selectRaw("json_object('fund_source',client_financial_status.fund_source,'other_fund_source',client_financial_status.other_fund_source,'income',client_financial_status.annual_income,'net',client_financial_status.net_assets) as original")
                    ->where('client_financial_status_updates.status','=','pending')
                )->union(ClientInvestmentExperienceUpdate::leftJoin('client_investment_experience','client_investment_experience_updates.uuid','=','client_investment_experience.uuid')
                    ->select('client_investment_experience_updates.id','client_investment_experience_updates.uuid','client_investment_experience_updates.created_at')->selectRaw("'ClientInvestmentExperienceUpdate' as model")
                    ->selectRaw("json_object('investment_objective',client_investment_experience_updates.investment_objective,'other_investment_objective',client_investment_experience_updates.other_investment_objective,'stock',client_investment_experience_updates.stock,'derivative_warrants',client_investment_experience_updates.derivative_warrants,'cbbc',client_investment_experience_updates.cbbc,'futures_and_options',client_investment_experience_updates.futures_and_options,'bonds_funds',client_investment_experience_updates.bonds_funds,'other_investment_experience',client_investment_experience_updates.other_investment_experience) as updating")
                    ->selectRaw("json_object('investment_objective',client_investment_experience.investment_objective,'other_investment_objective',client_investment_experience.other_investment_objective,'stock',client_investment_experience.stock,'derivative_warrants',client_investment_experience.derivative_warrants,'cbbc',client_investment_experience.cbbc,'futures_and_options',client_investment_experience.futures_and_options,'bonds_funds',client_investment_experience.bonds_funds,'other_investment_experience',client_investment_experience.other_investment_experience) as original")
                    ->where('client_investment_experience_updates.status','=','pending')
                )->union(
                    DB::query()->fromSub(
                        ClientInvestmentOrientationUpdate::leftJoin('client_investment_orientation',function($join){
                            $join->on('client_investment_orientation_updates.uuid','=','client_investment_orientation.uuid')
                            ->where('client_investment_orientation_updates.question_text','=','client_investment_orientation.question_text');
                        })->select('client_investment_orientation_updates.id','client_investment_orientation_updates.uuid','client_investment_orientation_updates.created_at')
                        ->selectRaw("concat('\"',client_investment_orientation_updates.question_text,'\":\"',client_investment_orientation_updates.answer,'\"') as updating")
                        ->selectRaw("concat('\"',client_investment_orientation.question_text,'\":\"',client_investment_orientation.answer,'\"') as original")
                        ->where('client_investment_orientation_updates.status','=','pending')
                        ->getQuery(),'OU'
                    )->groupBy('uuid')
                    ->select('OU.uuid')
                    ->selectRaw('min(OU.id) as id')
                    ->selectRaw('min(OU.created_at) as created_at')
                    ->selectRaw("'ClientInvestmentOrientationUpdate' as model")
                    ->selectRaw("cast(concat('{',group_concat(updating),'}') as char(2048)) as updating")
                    ->selectRaw("cast(concat('{',group_concat(original),'}') as char(2048)) as original")
                )->union(ClientWorkingStatusUpdate::leftJoin('client_working_status','client_working_status_updates.uuid','=','client_working_status.uuid')
                    ->select('client_working_status_updates.id','client_working_status_updates.uuid','client_working_status_updates.created_at')->selectRaw("'ClientWorkingStatusUpdate' as model")
                    ->selectRaw("json_object('working_status',client_working_status_updates.working_status,'company_name',client_working_status_updates.company_name,'company_tel',client_working_status_updates.company_tel,'school_name',client_working_status_updates.school_name,'industry',client_working_status_updates.industry,'position',client_working_status_updates.position) as updating")
                    ->selectRaw("json_object('working_status',client_working_status.working_status,'company_name',client_working_status.company_name,'company_tel',client_working_status.company_tel,'school_name',client_working_status.school_name,'industry',client_working_status.industry,'position',client_working_status.position) as original")
                    ->where('client_working_status_updates.status','=','pending')
                )->getQuery(),'t'
            )->leftJoinSub(
                ClientAyersAccount::select('uuid')->selectRaw('substr(min(account_no),1,length(min(account_no))-2) as client_id')->groupBy('uuid'),
                'client_ayers_account',
                function($join){
                    $join->on('client_ayers_account.uuid','=','t.uuid');
                }
            )->leftJoin('a_client_listing_csv02',function($join){
                $join->on('a_client_listing_csv02.client_id','=','client_ayers_account.client_id');
            })->select('model','t.id','name','client_ayers_account.client_id','phone as mobile','email','updating','original','t.created_at')
        ,'t2');
        foreach($filter as $f){
            if($request->has($f) && ($input[$f]??'')!='') $query->where($f,'like','%'.$input[$f].'%');
        }
        return $query->paginate(30);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
