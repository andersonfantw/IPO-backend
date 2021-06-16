<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

class CysislProductInfo extends Model
{
    use tableAssist;
    
    protected $table = 'cysisl_product_info';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'product_code',
        'exchange_code',
        'short_name',
        'eng_name',
        'big5_name',
        'ccy',
        'nominal',
        'status',
        'lot_size',
        'market_code',
        'instrument_type',
        'isin',
        'stamp',
        'ccass',
        'listing_date',
        'warrant_expiry_date',
    ];

    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}
