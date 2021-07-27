<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\MeteorsisSMS;
use App\Notifications\CYSSMail;
use App\Notifications\AccountOverview;
use App\Services\NotifyMessage;
use App\Services\NotifyService;
use App\NotificationRecord;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class NotificationRecordController extends HomeController
{
    protected $name = 'NotificationSummary';

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
        $input = $request->only('client_id','name','phone','email','date','route','status','content');
        $NotificationRecord = NotificationRecord::whereRaw('1=1');
        $f = false;
        if(strlen($input['client_id'])>=5){
            $f = true;
            $NotificationRecord->where('client_id','like',$input['client_id'].'%');
        }elseif(!empty($input['name'])){
            $f = true;
            $NotificationRecord->where('name','like',$input['name'].'%');
        }elseif(!empty($input['phone'])){
            $f = true;
            $NotificationRecord->where('phone','like',$input['phone'].'%');
        }elseif(!empty($input['email'])){
            $f = true;
            $NotificationRecord->where('email','like',$input['email'].'%');
        }
        if($request->has('date')){
            if($input['date'][0]!='null'){
                $NotificationRecord->whereDate('sending_time','>=',$input['date'][0])->whereDate('sending_time','<=',$input['date'][1]);
            }
        }
        if($input['route']!='all'){
            $NotificationRecord->where('route','=',$input['route']);
        }
        if($input['status']!='all'){
            $NotificationRecord->where('status','=',$input['status']);
        }
        if($input['content']!=''){
            $NotificationRecord->where(function($query) use($input){
                $query->where('title','like','%'.$input['content'].'%')
                    ->orWhere('content','like','%'.$input['content'].'%');
            });
        }
        $NotificationRecord->orderByDesc('sending_time');
        return $f?$NotificationRecord->paginate(30):[];
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
        (new NotifyService)->notify(new NotifyMessage($request));
        return ['ok' => true];
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
        $NotificationRecord = NotificationRecord::findOrFail($id);
        if($NotificationRecord->status=='success') return ['ok'=>false];
        NotificationRecord::destroy($id);
        return ['ok'=>true];
    }

    public function preview($template_id, Request $request){
        $input = $request->only('client_id');
        $NotifyMessage = (new NotifyMessage)->templateId($template_id);
        if($request->has('client_id')) if($input['client_id']!='') $NotifyMessage->clientId($input['client_id']);
        return (new CYSSMail($NotifyMessage))->toMail();
    }

    public function notifyDb(){
        $NotificationRecord = NotificationRecord::find(5624);
        $NotificationRecord->notify(new AccountOverview(
            (new NotifyMessage)->modelNotificationRecord($NotificationRecord)
        ));
    }
    public function unread(){
        $NotificationRecord = NotificationRecord::where('client_id','=','200001')->get();
        $result = [];
        foreach($NotificationRecord as $row){
            foreach ($row->unreadNotifications as $notification) {
                $result[] = $notification->data;
            }
        }
        return $result;
    }
}
