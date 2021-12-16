<?php

namespace App\Notifications;

use App;
use App\Channels\CYSSMailChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NotificationRecord;
use App\Models\NotificationTemplate;
use App\Services\NotifyMessage;

/**
 * 系統寄送郵件
 * 必須填寫subject
 * 有template_id 就不需要 content
 * 部分template需要params，未設定到的參數會以預設參數帶入
 */
class CYSSMail extends Notification implements ShouldQueue
{
    use Queueable;

    private $NotifyMessage;

    /**
     * Create a new notification instance.
     *
     * @param NotifyMessage $NotifyMessage
     */
    public function __construct(NotifyMessage $NotifyMessage)
    {
        $this->NotifyMessage = $NotifyMessage;
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            CYSSMailChannel::class => 'notify',
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CYSSMailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        // 記錄每一個template中的必要params
        $template_params = [
            'email.OpenAccountEmail' => [
                'account_name' => '客戶姓名',
                'account_no' => '帳戶號碼',
                'account_type' => '帳戶類型',
                'risk_tolerance' => '風險承受能力',
            ]
        ];
        
        $MailMessage = (new MailMessage)->subject($this->NotifyMessage->getTitle());
        if(!empty($this->NotifyMessage->getTemplate())){
            // 對應到 notification_templates.blade
            $NotificationTemplate = NotificationTemplate::findOrFail($this->NotifyMessage->getTemplate());
            if($NotificationTemplate->blade!=''){
                // 使用view的版面
                if(array_key_exists($NotificationTemplate->blade,$template_params)){
                    $arr = $this->NotifyMessage->toParams();
                    $arr['content'] = str_replace(["\r\n", "\n", "\r"],'<br />',$arr['content']);
                    $params = array_merge(
                        $template_params[$NotificationTemplate->blade]??[],
                        $arr
                    );
                }
                App::setLocale('zh-hk');
                return $MailMessage->view($NotificationTemplate->blade,$params);
            }
        }

        // 使用markdown版面 default
        return $MailMessage->markdown('email.default',
            $this->NotifyMessage->toParams(['greeting'=>'尊敬的客戶您好:'])
        );
    }

    /**
     * 回傳NotificationRecord.id
     *
     * @return string
     */
    public function getRecordId(): string
    {
        return $this->NotifyMessage->getRecordId();
    }
    public function getEmail(): string
    {
        return $this->NotifyMessage->getEmail();
    }
}
