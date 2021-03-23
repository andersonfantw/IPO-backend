<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAddressProof extends Model
{
    protected $table = 'client_address_proof';
    protected $fillable = [
        'uuid',
        'image',
        'detailed_address',
        'address_text',
        'editable',
    ];
}
