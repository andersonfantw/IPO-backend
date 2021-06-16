<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

class A02 extends Model
{
    use tableAssist;
    
    protected $table = 'a_client_listing_csv02';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'client_id',
        'id_code',
        'name',
        'ae_code',
        'addr',
        'open_date',
        'phone',
        'email',
        'client_group_code',
    ];

    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}
