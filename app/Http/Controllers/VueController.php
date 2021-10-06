<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ForbiddenWords;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\AE;
use App\Client;
use App\Staff;
use App\CysislbGtsClientAcc;
use App\Models\NotificationTemplate;
use App\Services\NotifyMessage;

/**
 * 中台複用的component功能
 */
class VueController extends Controller
{
    public function getAe(){
        //return AE::select('name as text')->selectRaw('group_concat(code) as value')->groupBy('name')->get();
        return AE::select('name as text','uuid as value')->groupBy('name','uuid')->get();
    }
    public function getStaff(){
        return Staff::select('name as text','uuid as value')->get();
    }

    public function findClient(Request $request){
        $input = $request->only('acc_no');

        // return CysislbGtsClientAcc::select('client_acc_id','name')
        // ->where('client_acc_id','like',$input['acc_no'].'%')->get();

        return DB::query()
        ->fromSub(function($query){
            $query->select('name')
            ->selectRaw("substr(client_acc_id,1,length(client_acc_id)-2) as client_id")
            ->from('cysislb_gts_client_acc');
        },'t')->where('client_id','like',$input['acc_no'].'%')
        ->groupBy('client_id','name')->get();
    }

    function ForbiddenWords(){
        $import = Excel::toArray(new ForbiddenWords,Storage::path('notification/CNKeywordFilter.xls'));
        return array_map(function($row){
            return trim($row[0]);
        },$import[0]);
    }

    function NotificationTemplateList(Request $request){
        $input = $request->only('mode');
        $NotificationTemplate = NotificationTemplate::select('id as value','name as text','template as content','blade');
        switch($input['mode']){
            case 'sms':  $NotificationTemplate->sms(); break;
            case 'group_sms':  $NotificationTemplate->groupSms(); break;
            case 'email':  $NotificationTemplate->email(); break;
            case 'group_email':  $NotificationTemplate->groupEmail(); break;
            case 'account_overview':  $NotificationTemplate->accountOverview(); break;
            case 'group_account_overview':  $NotificationTemplate->groupAccountOverview(); break;
            case 'alloted_notice':  $NotificationTemplate->AllotedNotice(); break;
        }
        return $NotificationTemplate->get();
    }

    function ClientInfo(Request $request){
        $input = $request->only('client_id');
        $data = (new NotifyMessage)->clientId($input['client_id'])->toParams();
        $result=[];
        foreach($data as $k => $v) $result['['.$k.']'] = $v;
        return $result;

    }

    function ListClients(Request $request){
        $query = $this->ListClientsQuery($request);
        return $query->paginate(100);
    }

    function ListClientsQuery(Request $request){
        $input = $request->only('selected_plan','selected_ae','selected_not_client','selected_status','selected_cate','selected_risk');
        
        if($input['selected_not_client']??''=='opening'){
            return Client::select('email as name','mobile as phone','email')
            ->selectRaw("'' as addr")->selectRaw("0 as client_id")
            ->whereNotIn('uuid',function($query){
                $query->from('client_ayers_account')->select('uuid');
            });
        }

        $arr_codes = [
            'C' => ['HCS001'],
            'S' => ['HSS001','HSS002'],
        ];

        $ae_code = [];
        $condition_ae_code = [];
        $selected_plan = explode(',',$input['selected_plan']??'');
        $selected_ae = explode(',',$input['selected_ae']??'');
        $selected_status = explode(',',$input['selected_status']??'');
        $selected_cate = explode(',',$input['selected_cate']??'');
        $selected_risk = explode(',',$input['selected_risk']??'');

        $query = CysislbGtsClientAcc::select();
        if(count(array_intersect($selected_plan,['plan1','plan2']))==2){
        }elseif(in_array('plan1',$selected_plan)){
            if(($input['selected_ae']??'')==''){
                $query->whereRaw(sprintf("find_in_set(ae_code,'%s')",config('app.ae_code_pys')));
            }else{
                $AE = array_map(function($row){
                    if($row['uuid']=='e550be72-fcb1-4779-980f-f255ff6eb041') $row['codes'].=',AEWHC';
                    return $row;
                }, AE::select('uuid')->selectRaw("group_concat(code) as codes")->whereIn('uuid',$selected_ae)->groupBy('uuid')->get()->toArray());
                foreach($AE as $row) $ae_code = array_merge($ae_code,explode(',',$row['codes']));
            }
        }elseif(in_array('plan2',$selected_plan)){
            if(($input['selected_risk']??'')==''){
                $condition_ae_code=explode(',',config('app.ae_code_group'));
                foreach(['HH','MH','MM','LM'] as $v) $condition_ae_code[]='D'.$v.'%';
                $query->whereRaw("length(client_acc_id)=7");
            }else{
                foreach($selected_risk as $r) $condition_ae_code[] = 'D'.$r.'%';
            }
        }
        if(in_array('C',$selected_status)) $ae_code = array_merge($ae_code,$arr_codes['C']);
        if(in_array('S',$selected_status)) $ae_code = array_merge($ae_code,$arr_codes['S']);
        if(($input['selected_cate']??'')!=''){
            $query->where(function($query) use($selected_cate){
                if(in_array('cash',$selected_cate)) $query->orWhereRaw("substr(client_acc_id,-2,2)='08'");
                if(in_array('authorize',$selected_cate)) $query->orWhereRaw("substr(client_acc_id,-2,2)='13'");
            });
        }
        $query->where(function($query) use($ae_code, $condition_ae_code){
            if(!empty($ae_code)) $query->whereIn('ae_code',$ae_code);
            foreach($condition_ae_code as $r) $query->orWhere('ae_code','like', $r);
        });
        $query->select('name')->selectRaw('max(phone) as phone')->selectRaw('max(email) as email')->selectRaw("'' as addr")
            ->selectRaw('substr(min(client_acc_id),1,length(min(client_acc_id))-2) as client_id')
            ->groupBy('name');
        return DB::query()->fromSub($query,'t');
    }
}
