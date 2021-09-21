<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Services\NotifyService;
use App\Services\NotifyMessage;
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
use Carbon\Carbon;
use Image;

class ClientDataUpdateController extends Controller
{
    private $model_cname=[
        'ClientAddressProofUpdate'=>'住址證明',
        'ClientHKIDCardUpdate'=>'香港身分證',
        'ClientCNIDCardUpdate'=>'內地身分證',
        'ClientOtherIDCardUpdate'=>'海外身分證',
        'ClientWorkingStatusUpdate'=>'工作狀態',
        'ClientFinancialStatusUpdate'=>'財務狀態',
        'ClientInvestmentExperienceUpdate'=>'投資經驗',
        'ClientInvestmentOrientationUpdate'=>'投資方向',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter=['client_id','name','mobile','email','created_at','model','status'];
        $input = $request->only($filter);
        $query = $this->query();
        foreach($filter as $f){
            if($f=='created_at' && $request->has('created_at') && !empty($input['created_at']??[])) $query->whereDate($f,'>',$input[$f][0])->whereDate($f,'<',$input[$f][1]);
            elseif($request->has($f) && ($input[$f]??'')!='' && $input[$f]!='all') $query->where($f,'like','%'.$input[$f].'%');
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
    public function show(string $model, string $uuid)
    {
        $arr=[
            'ClientAddressProofUpdate'=>[
                '證明文件'=>"api/ClientDataUpdate/ClientAddressProofUpdate/$uuid/image"
            ],
            'ClientCNIDCardUpdate'=>[
                '身分證正面'=>"api/ClientDataUpdate/ClientCNIDCardUpdate/$uuid/idcard_face",
                '身分證反面'=>"api/ClientDataUpdate/ClientCNIDCardUpdate/$uuid/idcard_back", 
            ],
            'ClientHKIDCardUpdate'=>[
                '身分證正面'=>"api/ClientDataUpdate/ClientHKIDCardUpdate/$uuid/idcard_face",
                '身分證反面'=>"api/ClientDataUpdate/ClientHKIDCardUpdate/$uuid/idcard_back",
            ],
            'ClientOtherIDCardUpdate'=>[
                '身分證正面'=>"api/ClientDataUpdate/ClientOtherIDCardUpdate/$uuid/idcard_face",
                '身分證反面'=>"api/ClientDataUpdate/ClientOtherIDCardUpdate/$uuid/idcard_back",
            ],
            'ClientWorkingStatusUpdate'=>[
                '名片'=>"api/ClientDataUpdate/ClientWorkingStatusUpdate/$uuid/name_card_face"
            ]
        ];
        if(!array_key_exists($model,$arr) || is_null($uuid)) abort(404);
        return array_merge(
            collect($this->query()->where('model','=',$model)->where('uuid','=',$uuid)->first())->toArray(),
            ['images'=>$arr[$model]]
        );
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
     * 更新的資料來源於updates的資料庫中
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $model, string $uuid)
    {
        $input = $request->only('method','remark');
        $ClientAyersAccount = ClientAyersAccount::select('account_no')->where('uuid','=',$uuid)->first();
        if(is_null($ClientAyersAccount)) abort(404);
        $client_id = substr($ClientAyersAccount->account_no,0,-2);
        if($model=='ClientInvestmentOrientationUpdate'){
            $ClientInvestmentOrientationUpdate = ClientInvestmentOrientationUpdate::select('uuid','question_text','answer')->where('uuid','=',$uuid)->where('status','=','pending')->get()->toArray();
            if($input['method']=='approved'){
                ClientInvestmentOrientation::upsert(
                    $ClientInvestmentOrientationUpdate,
                    ['uuid','question_text'],['answer']
                );
            }
            ClientInvestmentOrientationUpdate::upsert(
                array_map(function($row) use ($input){
                    return array_merge($row,['status'=>$input['method'],'remark'=>$input['remark']??null,'previewing_by'=>auth()->user()->name]);
                },$ClientInvestmentOrientationUpdate),
                ['uuid','question_text'],['status','remark','previewing_by']
            );
        }else{
            $s = Str::snake($model);
            $snake=$s;
            foreach(['_h_k_'=>'_hk_','_c_n_'=>'_cn_','_i_d_'=>'_id'] as $k=>$v){$snake=str_replace($k,$v,$snake);}
            $snake.='s';
            if(!in_array($snake,array_keys($this->data_fields))) abort(404);
            $update_table = "App\\".$model;
            $table = "App\\".str_replace('Update','',$model);
            if($input['method']=='approved'){
                $update_data = (new $update_table)->select(array_merge($this->data_fields[$snake],['id','status']))
                    ->where('uuid','=',$uuid)->where('status','=','pending')->first();
                if($update_data==null) return ['ok'=>false,'msg'=>'update資料表資料不存在，可能資料已被更新!'];
                $data = (new $table)->select($this->data_fields[$snake])
                    ->where('uuid','=',$uuid)->first();
                if($data==null) return ['ok'=>false,'msg'=>"目標資料表不存在 $uuid 的資料"];
                foreach($this->data_fields[$snake] as $col) $data->$col = $update_data->$col;
                $data->save();
                $update_data->status='approved';
                $update_data->previewing_by=auth()->user()->name;
                $update_data->save();
                return ['ok'=>true];
            }elseif($input['method']=='rejected'){
                (new $update_table)->select(array_merge($this->data_fields[$snake],['status']))
                    ->where('uuid','=',$uuid)->where('status','=','pending')->update([
                        'status'=>'rejected',
                        'remark'=>$input['remark'],
                        'previewing_by'=>auth()->user()->name,
                    ]);
            }

            (new NotifyService)->notify(
                (new NotifyMessage)->route('account_overview')
                    ->clientId('200001') //$client_id
                    ->templateId(($input['method']=='approved')?10:11)
                    ->params([
                        'form_name'=>$this->model_cname[$model],
                        'datetime'=>Carbon::now(),
                        'reason'=>$input['remark']])
            );
            return ['ok'=>true];
        }
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

    public function modelCname(){
        return array_map(function($k,$v){
            return ['value'=>$k,'text'=>$v];
        },array_keys($this->model_cname),$this->model_cname);
    }

    private $data_fields=[
        'client_address_proof_updates'=>['address_text'],
        'client_business_type_updates'=>['business_type','agree_direct_promotion','direct_promotion'],
        'client_cn_idcard_updates'=>['type','nationality','gender','birthday','name_c','surname','given_name','idcard_no','idcard_address','issued_by','valid_date'],
        'client_hk_idcard_updates'=>['type','name_c','name_en','gender','birthday','idcard_no'],
        'client_other_idcard_updates'=>['type','name_c','name_en','gender','birthday','idcard_no'],
        'client_financial_status_updates'=>['fund_source','other_fund_source','annual_income','net_assets'],
        'client_investment_experience_updates'=>['investment_objective','other_investment_objective','stock','derivative_warrants','cbbc','futures_and_options','bonds_funds','other_investment_experience'],
        // 'ClientInvestmentOrientationUpdate'=>[],
        'client_working_status_updates'=>['working_status','company_name','company_tel','school_name','industry','position'],
    ];
    private function jsonObjectRaw(string $model){
        $isUpdate = Str::endsWith($model,['_updates']);
        $_model = $isUpdate?$model:$model.'_updates';       
        $arr = [];
        foreach($this->data_fields[$_model] as $col) $arr[] = sprintf("'%s',%s.%s",$col,$model,$col);
        return sprintf("json_object(%s) as %s", implode(',',$arr),$isUpdate?'updating':'original');
    }

    private function query(){
        return DB::query()->fromSub(
            DB::query()->fromSub(
                ClientAddressProofUpdate::leftJoin('client_address_proof','client_address_proof_updates.uuid','=','client_address_proof.uuid')
                ->select('client_address_proof_updates.uuid','client_address_proof_updates.id','client_address_proof_updates.status','client_address_proof_updates.created_at')
                ->selectRaw("'ClientAddressProofUpdate' as model")
                ->selectRaw("1 as image")
                ->selectRaw($this->jsonObjectRaw('client_address_proof_updates'))
                ->selectRaw($this->jsonObjectRaw('client_address_proof'))
                // ->where('client_address_proof_updates.status','=','pending')
                ->union(ClientBusinessTypeUpdate::leftJoin('client_business_type','client_business_type_updates.uuid','=','client_business_type.uuid')
                    ->select('client_business_type_updates.uuid','client_business_type_updates.id','client_business_type_updates.status','client_business_type_updates.created_at')
                    ->selectRaw("'ClientBusinessTypeUpdate' as model")
                    ->selectRaw("0 as image")
                    ->selectRaw($this->jsonObjectRaw('client_business_type_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_business_type'))
                    // ->where('client_business_type_updates.status','=','pending')
                )->union(ClientCNIDCardUpdate::leftJoin('client_cn_idcard','client_cn_idcard_updates.uuid','=','client_cn_idcard.uuid')
                    ->select('client_cn_idcard_updates.uuid','client_cn_idcard_updates.id','client_cn_idcard_updates.status','client_cn_idcard_updates.created_at')
                    ->selectRaw("'ClientCNIDCardUpdate' as model")
                    ->selectRaw("1 as image")
                    ->selectRaw($this->jsonObjectRaw('client_cn_idcard_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_cn_idcard'))
                    // ->where('client_cn_idcard_updates.status','=','pending')
                )->union(ClientHKIDCardUpdate::leftJoin('client_hk_idcard','client_hk_idcard_updates.uuid','=','client_hk_idcard.uuid')
                    ->select('client_hk_idcard_updates.uuid','client_hk_idcard_updates.id','client_hk_idcard_updates.status','client_hk_idcard_updates.created_at')
                    ->selectRaw("'ClientHKIDCardUpdate' as model")
                    ->selectRaw("1 as image")
                    ->selectRaw($this->jsonObjectRaw('client_hk_idcard_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_hk_idcard'))
                    // ->where('client_hk_idcard_updates.status','=','pending')
                )->union(ClientOtherIDcardUpdate::leftJoin('client_other_idcard','client_other_idcard_updates.uuid','=','client_other_idcard.uuid')
                    ->select('client_other_idcard_updates.uuid','client_other_idcard_updates.id','client_other_idcard_updates.status','client_other_idcard_updates.created_at')
                    ->selectRaw("'ClientOtherIDcardUpdate' as model")
                    ->selectRaw("1 as image")
                    ->selectRaw($this->jsonObjectRaw('client_other_idcard_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_other_idcard'))
                    // ->where('client_other_idcard_updates.status','=','pending')
                )->union(ClientFinancialStatusUpdate::leftJoin('client_financial_status','client_financial_status_updates.uuid','=','client_financial_status.uuid')
                    ->select('client_financial_status_updates.uuid','client_financial_status_updates.id','client_financial_status_updates.status','client_financial_status_updates.created_at')
                    ->selectRaw("'ClientFinancialStatusUpdate' as model")
                    ->selectRaw("0 as image")
                    ->selectRaw($this->jsonObjectRaw('client_financial_status_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_financial_status'))
                    // ->where('client_financial_status_updates.status','=','pending')
                )->union(ClientInvestmentExperienceUpdate::leftJoin('client_investment_experience','client_investment_experience_updates.uuid','=','client_investment_experience.uuid')
                    ->select('client_investment_experience_updates.uuid','client_investment_experience_updates.id','client_investment_experience_updates.status','client_investment_experience_updates.created_at')
                    ->selectRaw("'ClientInvestmentExperienceUpdate' as model")
                    ->selectRaw("0 as image")
                    ->selectRaw($this->jsonObjectRaw('client_investment_experience_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_investment_experience'))
                    // ->where('client_investment_experience_updates.status','=','pending')
                )->union(
                    DB::query()->fromSub(
                        ClientInvestmentOrientationUpdate::leftJoin('client_investment_orientation',function($join){
                            $join->on('client_investment_orientation_updates.uuid','=','client_investment_orientation.uuid')
                            ->where('client_investment_orientation_updates.question_text','=','client_investment_orientation.question_text');
                        })->select('client_investment_orientation_updates.id','client_investment_orientation_updates.uuid','client_investment_orientation_updates.status','client_investment_orientation_updates.created_at')
                        ->selectRaw("concat('\"',client_investment_orientation_updates.question_text,'\":\"',replace(replace(replace(client_investment_orientation_updates.answer,'[',''),']',''),'\"',''),'\"') as updating")
                        ->selectRaw("concat('\"',client_investment_orientation.question_text,'\":\"',replace(replace(replace(client_investment_orientation.answer,'[',''),']',''),'\"',''),'\"') as original")
                        // ->where('client_investment_orientation_updates.status','=','pending')
                        ->getQuery(),'OU'
                    )->groupBy('uuid')
                    ->select('OU.uuid')
                    ->selectRaw('min(OU.id) as id')
                    ->selectRaw('min(OU.status) as status')
                    ->selectRaw('min(OU.created_at) as created_at')
                    ->selectRaw("'ClientInvestmentOrientationUpdate' as model")
                    ->selectRaw("0 as image")
                    ->selectRaw("concat('{',group_concat(updating),'}') as updating")
                    ->selectRaw("concat('{',group_concat(original),'}') as original")
                )->union(ClientWorkingStatusUpdate::leftJoin('client_working_status','client_working_status_updates.uuid','=','client_working_status.uuid')
                    ->select('client_working_status_updates.uuid','client_working_status_updates.id','client_working_status_updates.status','client_working_status_updates.created_at')
                    ->selectRaw("'ClientWorkingStatusUpdate' as model")
                    ->selectRaw("1 as image")
                    // ->selectRaw("json_object('working_status',client_working_status_updates.working_status,'company_name',client_working_status_updates.company_name,'company_tel',client_working_status_updates.company_tel,'school_name',client_working_status_updates.school_name,'industry',client_working_status_updates.industry,'position',client_working_status_updates.position) as updating")
                    // ->selectRaw("json_object('working_status',client_working_status.working_status,'company_name',client_working_status.company_name,'company_tel',client_working_status.company_tel,'school_name',client_working_status.school_name,'industry',client_working_status.industry,'position',client_working_status.position) as original")
                    ->selectRaw($this->jsonObjectRaw('client_working_status_updates'))
                    ->selectRaw($this->jsonObjectRaw('client_working_status'))
                    // ->where('client_working_status_updates.status','=','pending')
                )->getQuery(),'t'
            )->leftJoinSub(
                ClientAyersAccount::select('uuid')->selectRaw('substr(min(account_no),1,length(min(account_no))-2) as client_id')->groupBy('uuid'),
                'client_ayers_account',
                function($join){
                    $join->on('client_ayers_account.uuid','=','t.uuid');
                }
            )->leftJoin('a_client_listing_csv02',function($join){
                $join->on('a_client_listing_csv02.client_id','=','client_ayers_account.client_id');
            })->select('model','t.uuid','name','image','client_ayers_account.client_id','phone as mobile','email','updating','original','status','t.created_at')
        ,'t2');
    }

    public function image(string $model, string $uuid, string $img_name){
        switch($model){
            case 'ClientAddressProofUpdate':
                $arr = ['image'];
                $result = ClientAddressProofUpdate::where('uuid','=',$uuid)->where('status','=','pending')->first()->toArray();
                break;
            case 'ClientCNIDCardUpdate':
                $arr = ['idcard_face','idcard_back'];
                $result = ClientCNIDCardUpdate::where('uuid','=',$uuid)->where('status','=','pending')->first()->toArray();
                break;
            case 'ClientHKIDCardUpdate':
                $arr = ['idcard_face','idcard_back'];
                $result = ClientHKIDCardUpdate::where('uuid','=',$uuid)->where('status','=','pending')->first()->toArray();
                break;
            case 'ClientOtherIDcardUpdate':
                $arr = ['idcard_face','idcard_back'];
                $result = ClientOtherIDcardUpdate::where('uuid','=',$uuid)->where('status','=','pending')->first()->toArray();
                break;
            case 'ClientWorkingStatusUpdate':
                $arr = ['name_card_face'];
                $result = ClientWorkingStatusUpdate::where('uuid','=',$uuid)->where('status','=','pending')->first()->toArray();
                break;
        }
        if(!in_array($img_name,$arr)) abort(404);
        if($result[$img_name]==null){
            return Response::make(Storage::get('public/no-photo.gif'),200)->header('Content-Type', 'image/gif');
        }
        $image_file = Image::make($result[$img_name]);
        $image_file->resize(800,800,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        return Response::make($image_file->encode('jpeg'))->header('Content-Type', 'image/jpeg');
    }
}
