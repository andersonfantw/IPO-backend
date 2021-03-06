<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\NotificationGroup;
use App\Models\NotificationTemplate;

class NotifyMessage{
    private $title=null;
    private $content=null;
    private $record_id=0;
    private $template_id=0;
    private $group_id=0;
    private $client_id=null;
    private $mobile=null;
    private $email=null;
    private $route='account_overview';
    private $issued_by=null;
    private $autoTranslate=true;

    private $send_now=false;
    private $_params=[];
    private $params=[];
    private $model_group=null;
    private $model_record=null;
    private $row_client_info=null;

    function title($title){ $this->title=$title; return $this; }
    function content($content){ $this->content=$content; return $this; }
    function recordId($record_id){ $this->record_id=$record_id; return $this; }
    function templateId($template_id){ $this->template_id=$template_id; return $this; }
    function groupId($group_id){ $this->group_id=$group_id; return $this; }
    function clientId($client_id){ $this->client_id=$client_id; return $this; }
    function email($email){ $this->email=$email; $this->route='email'; return $this; }
    function mobile($mobile){ $this->mobile=$mobile; $this->route='sms'; return $this; }
    function route($route){ $this->route=$route; return $this; }
    function params($params){ $this->params=$params; return $this; }

    function getRecordId(){ return $this->record_id; }
    function getEmail(){ return $this->email; }
    function getMobile(){ return $this->mobile; }
    function getTitle(){ return $this->title; }
    function getContent(){ return $this->content; }
    function getRoute(){ return $this->route; }
    function getTemplate(){ return $this->template_id; }
    function isSendNow(){ return $this->send_now; }

    function enableTranslate(){$this->autoTranslate=true;}
    function disableTranslate(){$this->autoTranslate=false;}

    function modelNotificationGroup($model){
        $this->model_group = $model;
        $this->group_id = $model->id;
        $this->route = $model->route;
        $this->template = $model->notification_template_id;
        $this->title = $model->title;
        $this->content = $model->content;
        return $this;
    }
    function modelNotificationRecord($model){
        $this->model_record = $model;
        $this->record_id = $model->id;
        $this->route = $model->route;
        $this->client_id = $model->client_id;
        $this->group_id = $model->notification_group_id;
        $this->template = $model->notification_template_id;
        $this->title = $model->title;
        $this->content = $model->content;
        $this->name = $model->name;
        $this->mobile = $model->phone;
        $this->email = $model->email;
        $this->issued_by = $model->issued_by;
        return $this;
    }
    /**
     * ????????????????????????data row
     *
     * @param [type] $row
     * @return NotifyMessage
     */
    function rowClientInfo($row){
        $this->row_client_info = $row;
        return $this;
    }

    function __construct(Request $request=null){
        if(is_null($request)) return $this;
        $input = $request->only(['_route','client_id','template','mobile','email','title','content']);
        if(array_key_exists('_route',$input)) $this->route = $input['_route'];
        if(array_key_exists('title',$input)) $this->title = $input['title'];
        if(array_key_exists('content',$input)) $this->content = $input['content'];
        if(array_key_exists('email',$input)) $this->email = $input['email'];
        if(array_key_exists('mobile',$input)) $this->mobile = $input['mobile'];
        if(array_key_exists('template',$input)) $this->template_id = $input['template'];
        if(array_key_exists('client_id',$input)) $this->client_id = $input['client_id'];
        return $this;
    }

    /**
     * 
     * ??????NotificationRecords?????????
     *
     * @return array
     */
    function toData(): array
    {
        // ???????????????????????????????????????????????????????????????????????????????????????????????????????????????
        $this->_params = $this->toParams();

        if(in_array($this->route,['email','account_overview']))
            if($this->title=='') abort(500,sprintf('[NotifyMessage] route=%s ?????????????????? title',$this->route));

        $_params=[]; // ??????????????????????????????
        foreach($this->_params as $k => $v) $_params['['.$k.']'] = $v;
        $title = strtr($this->title,$_params);
        $content = strtr($this->content,$_params);
        if(substr($this->mobile,0,2)=='86' && strlen($this->mobile)==13){
            $title = \OpenCC::convert($title,'t2s.json');
            $content = \OpenCC::convert($content,'t2s.json');
        }

        return [
            'notification_group_id' => 0,
            'route' => $this->route,
            'notification_template_id' => $this->template_id,
            'client_id' => $this->client_id??$_params['[client_id]'],
            'name' => $_params['[name]']??null,
            'phone' => $this->mobile??$_params['[phone]']??null,
            'email' => $this->email??$_params['[email]']??null,
            'title' => $title,
            'content' => $content,
            'issued_by' => auth()->user()->name??$this->issued_by??'', 
        ];
    }

    /**
     * @param array $params : ????????????????????????[]???
     * @return array
     */
    function toParams(array $params=[]):array
    {
        // ??????view??????????????????
        if(!empty($this->_params)) return $this->_params;

        if($this->group_id>0 && is_null($this->model_group)){
            $this->modelNotificationGroup(
                NotificationGroup::findOrFail($this->group_id)
            );
        }

        // ?????????Template?????????content??????content?????????????????????
        if($this->template_id>0 && $this->content==''){
            $NotificationTemplate = NotificationTemplate::findOrFail($this->template_id);
            $this->title = $this->title??$NotificationTemplate->name;
            $this->content = $this->content??$NotificationTemplate->template;
            if($this->autoTranslate){
                $this->title = \OpenCC::convert($this->title,'t2s.json');
                $this->content = \OpenCC::convert($this->content,'t2s.json');
            }
        }

        $_params = [];
        if(!is_null($this->row_client_info)){
            $arr = explode(' ',$this->row_client_info['name']);
            $zh_name = array_pop($arr);
            $en_name = implode(' ', $arr);
            $_params = [
                'client_id' => $this->row_client_info['client_id'],
                'name' => $this->row_client_info['name'],
                'en_name' => $en_name,
                'zh_name' => $zh_name,
                'addr' => $this->row_client_info['addr'],
                'phone' => $this->row_client_info['phone'],
                'email' => $this->row_client_info['email'],
                'title' => $this->title,
                'content' => $this->content,
            ];
        }elseif(!empty($this->client_id)){
            $row = DB::query()->select('t1.client_id','t1.name','addr','phone','email')
                ->fromSub(function($query){
                    $query->fromSub(function($query){
                        $query->select('name')
                            ->selectRaw('substr(client_acc_id,1,length(client_acc_id)-2) as client_id')
                            ->from('cysislb_gts_client_acc');
                    },'t')->distinct();
                },'t1')->leftJoin('a_client_listing_csv02','a_client_listing_csv02.client_id','=','t1.client_id')
                ->where('a_client_listing_csv02.client_id','=',$this->client_id)->first();
            $_params = collect($row)->toArray();
            $arr = explode(' ',$_params['name']);
            $zh_name = array_pop($arr);
            $en_name = implode(' ', $arr);
            $_params['en_name'] = $en_name;
            $_params['zh_name'] = $zh_name;
            $_params['title'] = $this->title;
            $_params['content'] = $this->content;
        }else{
            $_params['title'] = $this->title;
            $_params['content'] = $this->content;
        }
        return $this->_params = array_merge(
            array_map(function($v){return ($v=='content')?$v:str_replace("\n","",$v);},$_params),
            $params,
            $this->params
        );
    }

    // ?????????????????????
    function toArray(){

    }

    function send(){
        $this->send_now = true;
    }
}