<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ForbiddenWords;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\AE;
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
        $input = $request->only('selected_ae','selected_cate');
        $ae_uuid = ($input['selected_ae']=='')?[]:explode(',',$input['selected_ae']);
        $cate = ($input['selected_cate']=='')?[]:explode(',',$input['selected_cate']);
        $query = CysislbGtsClientAcc::select();
        if(!empty($ae_uuid)){
            $query->whereIn('ae_code',function($query) use($ae_uuid){
                $query->from('ae')->select('code')->whereIn('uuid',$ae_uuid);
                if(in_array('e550be72-fcb1-4779-980f-f255ff6eb041',$ae_uuid)){
                    $query->union(DB::query()->selectRaw("'AEWHC' as code"));
                }
            });
        }
        if(!empty($cate)){
            foreach($cate as $c){
                switch($c){
                    case 'cash':
                        $query->where(function($query){
                            $query->where('status','=','A')
                            ->whereRaw("LOCATE('CLOSED',UPPER(name))=0")
                            ->whereRaw("LOCATE('SUSPENDED',UPPER(name))=0")
                            ->where(function($query){
                                $query->whereRaw("substr(client_acc_id,length(client_acc_id)-1)='08'")
                                ->whereRaw("LOCATE('(CLOSED)',UPPER(name))=0")
                                ->whereRaw("LOCATE('SUSPENDED',UPPER(name))=0")
                                ->where('status','=','A');
                            })
                            ->whereNotIn('client_acc_id',function($query){
                                $query->selectRaw("concat(substr(client_acc_id,1,length(client_acc_id)-2),'08') as client_acc_id")
                                ->from('cysislb_gts_client_acc')
                                ->whereRaw("substr(client_acc_id,length(client_acc_id)-1)='13'")
                                ->whereRaw("LOCATE('(CLOSED)',UPPER(name))=0")
                                ->whereRaw("LOCATE('SUSPENDED',UPPER(name))=0")
                                ->where('status','=','A');
                            });
                        });
                        break;
                    case 'authorize_deposit':
                        $query->whereIn('client_acc_id',function($query){
                            $query->selectRaw('substr(client_acc_id,1,length(client_acc_id)-2) as client_id')
                            ->from('ipo_initial_value');
                        });
                        break;
                    case 'authorize':
                        $query->whereNotIn('client_acc_id', function($query){
                            $query->select('client_acc_id')->from('ipo_initial_value');
                        });
                        break;
                    case 'suspend':
                        case 'closed':
                            $query->orWhere('status','=','S');
                            break;    
                        break;
                    case 'opening':
                        break;
                    case 'closed':
                        $query->orWhere('status','=','C');
                        break;
                }
            }
        }
        //dd($query->toSql());
        return $query->get();

    }
}
