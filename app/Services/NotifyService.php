<?php
use Illuminate\Database\Eloquent\Collection;
use App\NotificationTemplate;
use App\NotificationRecord;
use App\Services\NotifyMessage;

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
        $this->save();
        switch($this->NotifyMessage->getRoute()){
            case 'sms':
                $NotificationRecord->notify(new MeteorsisSMS($NotifyMessage));
                break;
            case 'email':
                $NotificationRecord->notify(new CYSSMail($NotifyMessage));
                break;
            case 'account_overview':
                break; 
        }
    }
}