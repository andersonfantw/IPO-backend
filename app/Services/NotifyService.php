<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\NotificationTemplate;
use App\NotificationRecord;
use App\Services\NotifyMessage;
use App\Notifications\MeteorsisSMS;
use App\Notifications\CYSSMail;
use App\Notifications\AccountOverview;
use Carbon\Carbon;

class NotifyService{
    private $saved=false;

    /**
     * 需要審核後發送
     *
     * @param NotifyMessage $NotifyMessage
     * @return void
     */
    public function save(NotifyMessage $NotifyMessage){
        if(!$this->saved) $NotificationRecord = NotificationRecord::create($NotifyMessage->toData());
        $this->saved = true;
    }

    /**
     * 直接發送，在通知中心查看發送記錄
     *
     * @param NotifyMessage $NotifyMessage
     * @return void
     */
    public function notify(NotifyMessage $NotifyMessage){
        $NotificationRecord = NotificationRecord::create($NotifyMessage->toData());
        $NotifyMessage->recordId($NotificationRecord->id);
        switch($NotifyMessage->getRoute()){
            case 'sms':
                $NotificationRecord->notify(new MeteorsisSMS($NotifyMessage));
                break;
            case 'email':
                $NotificationRecord->notify(new CYSSMail($NotifyMessage));
                break;
            case 'account_overview':
                $NotificationRecord->notify(new AccountOverview($NotifyMessage));
                $NotificationRecord->sending_time = Carbon::now();
                $NotificationRecord->status='success';
                $NotificationRecord->save();
                break; 
        }
    }
}