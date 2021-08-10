<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;

class NotificationRecord extends Model
{
    use Notifiable;

    protected $fillable = ['notification_group_id','route','notification_template_id','client_id','name','phone','email','title','content','status','remark','issued_by'];
    public function scopeOfParentID(Builder $query, $id){
        return $query->where('notification_group_id','=',$id);
    }

    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->name];
    }

    public function routeNotificationForMeteorsis($notification)
    {
        return self::hotfix_phone_number($this->phone);
    }

    /**
     * hotfix
     * 修正Ayers中電話資料部分未加上國碼。
     * 修改資料供應商會收費，資料做一次性修正。
     *
     * @param string $str
     * @return string
     */
    public static function hotfix_phone_number(string $str): string{
        switch(strlen($str)){
            case 8: return '852'.$str; // 香港
            case 9: return '886'.$str; // 台灣
            case 10: return '886'.substr($str,1,9); // 台灣
            case 11: return (substr($str,0,3)=='852')?$str:'86'.$str; // 香港/大陸
            default: return $str;
        }
    }
}
