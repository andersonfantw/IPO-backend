<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    public function scopeSms($query){
        return $query->where(function($query){
            $query->whereNull('cate')->orWhere('cate','=','sms');
        });
    }
    public function scopeGroupSms($query){
        return $query->where(function($query){
            $query->where('cate','=','group')->orWhere('cate','=','sms')->orWhere('cate','=','group_sms');
        });
    }
    public function scopeEmail($query){
        return $query->where(function($query){
            $query->whereNull('cate')->orWhere('cate','=','email');
        });
    }
    public function scopeGroupEmail($query){
        return $query->where(function($query){
            $query->where('cate','=','group')->orWhere('cate','=','email')->orWhere('cate','=','group_email');
        });
    }
    public function scopeAccountOverview($query){
        return $query->where(function($query){
            $query->whereNull('cate')->orWhere('cate','=','account_overview');
        });
    }
    public function scopeGroupAccountOverview($query){
        return $query->where(function($query){
            $query->where('cate','=','group')->orWhere('cate','=','account_overview')->orWhere('cate','=','group_account_overview');
        });
    }
    public function scopeAllotedNotice($query){
        return $query->whereIn('id',[5,6]);
    }
}
