<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffilateIncome extends Model
{
    protected $table = 'affilate_income';
    protected $fillable = [
        'client_id','direct_id','affilate_amount','affilate_token'
    ];
}
