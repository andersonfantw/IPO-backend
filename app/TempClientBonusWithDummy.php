<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempClientBonusWithDummy extends Model
{
    protected $table = 'tt_client_bonus_with_dummy';
    public function ClientInfo(){
        return $this->hasOne('App\CysislbGtsClientAcc','client_acc_id','client_acc_id');
    }
}
