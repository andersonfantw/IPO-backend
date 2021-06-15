<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAddressProofUpdate extends Model
{
    protected $table = 'client_address_proof_updates';
    protected $fillable = [
        'uuid',
        'image',
        'detailed_address',
        'address_text',
        'status',
        'remark',
        'count_of_audits',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
