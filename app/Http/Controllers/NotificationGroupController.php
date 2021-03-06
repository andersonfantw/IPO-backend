<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NotificationSendingList;
use App\Imports\AllotedNotice;
use App\Models\NotificationGroup;
use App\Models\NotificationRecord;
use App\Models\NotificationTemplate;
use App\Services\NotifyMessage;
use App\Jobs\SendNotificationJobCreate;

class NotificationGroupController extends HomeController
{
    protected $name = 'NotificationGroup';

    public function indexView(Request $request){
        return parent::index($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only('content','date','route');
        $NotificationGroup = DB::query()
            ->select('id','route','title','content','notification_template_id')
            ->selectRaw('(select min(sending_time) from notification_records where notification_groups.id=notification_group_id) as sending_time')
            ->selectRaw('ifnull(nulls,0) as nulls')
            ->selectRaw('ifnull(failure,0) as failure')
            ->selectRaw('ifnull(success,0) as success')
            ->selectRaw('ifnull(pending,0) as pending')
            ->selectRaw('ifnull(nulls,0)+ifnull(failure,0)+ifnull(success,0)+ifnull(pending,0) as total')
            ->fromSub(function($query){
                $query->fromSub(function($query){
                    $query->from('notification_records')
                        ->select('notification_group_id','status')
                        ->selectRaw('count(*) as num')
                        ->selectRaw('min(sending_time) as sending_time')
                        ->groupBy('notification_group_id','status');
                },'t')->select('notification_group_id')
                ->selectRaw("sum(IF(status is null, num, 0)) AS nulls")
                ->selectRaw("sum(IF(status='failure', num, 0)) AS failure")
                ->selectRaw("sum(IF(status='success', num, 0)) AS success")
                ->selectRaw("sum(IF(status='pending', num, 0)) AS pending")
                ->groupBy('notification_group_id');
            },'t1')->rightJoin('notification_groups','t1.notification_group_id','=','notification_groups.id');
        if($request->has('date')){
            if($input['date'][0]!='null'){
                $NotificationGroup->whereDate('sending_time','>=',$input['date'][0])->whereDate('sending_time','<=',$input['date'][1]);
            }
        }
        if($input['route']!='all'){
            $NotificationGroup->where('route','=',$input['route']);
        }
        if($input['content']!=''){
            $NotificationGroup->where(function($query) use($input){
                $query->where('title','like','%'.$input['content'].'%')
                ->orWhere('content','like','%'.$input['content'].'%');
            });
        }
        return $NotificationGroup->orderByDesc('created_at')->paginate(30);
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
        $input = $request->only(['_route','groups','template','title','content','condition']);
        $route = $input['_route'];

        // Create NotificationGroup
        $data = [
            'route' => $route,
            'notification_template_id' => $input['template'],
            'issued_by' => auth()->user()->name,
            'title' => $input['title']??null,
            'content' => $input['content']??null,
        ];
        if($request->hasFile('file') && $request->file('file')->isValid()) $data['import_list'] = file_get_contents($request->file('file'));
        $NotificationGroup = NotificationGroup::create($data);

        $data = [];
        if($input['_route']=='alloted_notice'){
            $result = $this->customizeNotice($request);
            $arr = ['alloted'=>6,'alloted_margin'=>6,'unalloted'=>5];
            $NotificationTemplate = NotificationTemplate::whereIn('id',array_values($arr))->get()->toArray();
            // prepare template for later
            $hash = [];
            foreach($NotificationTemplate as $row) $hash[$row['id']] = $row;
            // prepare client info for later
            $arr_clients = [];
            foreach($result as $k => $v) $arr_clients = array_merge($arr_clients, $v);
            $hashClientInfo = $this->hashClientInfo(
                array_map(function($row){
                    return $row['client_id'];
                },$arr_clients)
            );
            // make insert date
            foreach($arr as $k => $v){
                for($i=0;$i<count($result[$k]);$i++){
                    $data[] = array_merge(
                        (new NotifyMessage())->route('sms')->templateId($v)
                        ->rowClientInfo($hashClientInfo[$result[$k][$i]['client_id']])
                        ->params($result[$k][$i])
                        ->content($hash[$v]['template'])->toData(),
                        ['notification_group_id'=>$NotificationGroup->id]
                    );
                }
            }
        }elseif($request->hasFile('file') && $request->file('file')->isValid()){
            $file = $request->file('file');
            $imports = Excel::toArray(new NotificationSendingList,$request->file('file'));
            // ????????????????????????client_id????????????????????????
            if(count($imports)==0) return ['ok'=>false];
            $hash = [];
            if(array_key_exists('client_id',$imports[0][0])){
                $hash = $this->hashClientInfo(
                    array_map(function($v){
                        return (in_array(strlen($v['client_id']),[7,8]))?substr($v['client_id'],0,-2):$v['client_id'];
                    },$imports[0])
                );
            }
            foreach($imports[0] as $import){
                $client_id = null;
                $params = [];
                $NotifyMessage = (new NotifyMessage($request))->modelNotificationGroup($NotificationGroup);
                foreach($import as $k => $v){
                    switch($k){
                        case 'client_id': $client_id=$v; $NotifyMessage->clientId($v); break;
                        case 'mobile': $NotifyMessage->mobile($v); break;
                        case 'email': $NotifyMessage->email($v); break;
                        default:
                            $params[$k] = $v;
                            break;
                    }
                }
                if(array_key_exists($client_id, $hash)) $NotifyMessage->rowClientInfo($hash[$client_id]);
                $data[] = array_merge(
                    $NotifyMessage->toData($params),
                    ['notification_group_id'=>$NotificationGroup->id]
                );
                unset($NotifyMessage);
            }
        }else{
            $query = (new VueController)->ListClientsQuery($request);
            $data = [];
            foreach($query->get()->toArray() as $row){
                $row = collect($row)->toArray();
                $data[] = array_merge(
                    (new NotifyMessage($request))->modelNotificationGroup($NotificationGroup)->rowClientInfo($row)->toData(),
                    ['notification_group_id'=>$NotificationGroup->id]
                );
            }
        }

        NotificationRecord::insert($data);
        return ['ok'=>true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return NotificationGroup::findOrFail($id);
    }

    public function list($id, Request $request){
        $NotificationRecord = NotificationRecord::ofParentID($id);
        $request->whenFilled('client_id',function($input) use($NotificationRecord){
            $NotificationRecord->where('client_id','like',$input.'%');
        });
        $request->whenFilled('name',function($input) use($NotificationRecord){
            $NotificationRecord->where('name','like',$input.'%');
        });
        $request->whenFilled('email',function($input) use($NotificationRecord){
            $NotificationRecord->where('email','like',$input.'%');
        });
        $request->whenFilled('sms',function($input) use($NotificationRecord){
            $NotificationRecord->where('phone','like',$input.'%');
        });
        $request->whenFilled('status',function($input) use($NotificationRecord){
            if($input=='nulls') $NotificationRecord->whereNull('status');
            elseif($input!='all') $NotificationRecord->where('status','=',$input);
        });
        return $NotificationRecord->select('client_id','name','email','phone as sms','status')->paginate(20);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        // ?????????????????????????????????????????????
        $hasSend = NotificationRecord::ofParentID($id)->where('status','=','success')->get();
        if($hasSend->count()>0) return ['ok'=>false];
        NotificationRecord::ofParentID($id)->delete();
        NotificationGroup::destroy($id);
        return ['ok'=>true];
    }

    public function sendAll($id){
        dispatch(new SendNotificationJobCreate($id));
        return ['ok'=>true];
    }

    public function addClient($id,$client_id){
        $NotificationGroup = NotificationGroup::findOrFail($id);
        // ?????????????????????????????????????????????????????????????????????
        if(!is_null($NotificationGroup->import_list)) return ['ok'=>false];
        $NotificationRecord = NotificationRecord::ofParentID($id)->where('client_id','=',$client_id)->first();
        if(!is_null($NotificationRecord)) return ['ok'=>false];
        NotificationRecord::create(
            (new NotifyMessage)->clientId($client_id)
                ->modelNotificationGroup($NotificationGroup)->toData()
        );
        return ['ok'=>true];
    }

    public function customizeNotice(Request $request){
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $imports = Excel::toArray(new AllotedNotice,$request->file('file'));
            $arr = array_map(function($row){
                    return [
                        'product_id'=>$row['product_id'],
                        'product_name'=>$row['name'],
                        'client_id'=>substr($row['client_acc_id'],0,-2),
                        'client_name'=>$row['client_acc_name'],
                        'ae_code'=>$row['ae_code'],
                        'actual_qty'=>$row['actual_qty'],
                        'loan_amt'=>$row['loan_amt'],
                    ];
                },
                array_filter(
                    $imports[0],
                    function($row){
                        return (substr($row['client_acc_id'],-2)=='08');
                    }
                )
            );
            return [
                'alloted'=>array_values(
                    array_filter($arr,function($row){
                        return $row['actual_qty']>0 && $row['loan_amt']==0;
                    })
                ),
                'alloted_margin'=>array_values(
                    array_filter($arr,function($row){
                        return $row['actual_qty']>0 && $row['loan_amt']>0;
                    })
                ),
                'unalloted'=>array_values(
                    array_filter($arr,function($row){
                        return $row['actual_qty']==0;
                    })
                ),
            ];
        }
    }

    public function hashClientInfo($arr){
        $hash = [];
        $rows = DB::query()->select('t1.client_id','t1.name','addr','phone','email')
        ->fromSub(function($query){
            $query->fromSub(function($query){
                $query->select('name')
                    ->selectRaw('substr(client_acc_id,1,length(client_acc_id)-2) as client_id')
                    ->from('cysislb_gts_client_acc');
            },'t')->distinct();
        },'t1')->leftJoin('a_client_listing_csv02','a_client_listing_csv02.client_id','=','t1.client_id')
        ->whereIn('a_client_listing_csv02.client_id',$arr)->get();
        foreach($rows as $item){ $hash[$item->client_id] = array_map(function($v){return str_replace("\n","",$v);},collect($item)->toArray()); }
        return $hash;
    }
}
