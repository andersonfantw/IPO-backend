<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IpoActivityPeriod extends Model
{
    protected $dates = ['start_date','end_date'];
}
