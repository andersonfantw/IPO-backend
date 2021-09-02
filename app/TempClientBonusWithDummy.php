<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempClientBonusWithDummy extends Model
{
    protected $table = 'tt_client_bonus_with_dummy';
    public function CysislbGtsClientAcc(){
        return $this->belongsTo(CysislbGtsClientAcc::class);
    }
}
