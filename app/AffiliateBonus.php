<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateBonus extends Model
{
    protected $table = "affiliate_bonus";
    protected $fillable = [
        'client_id','affiliate_amount'
    ];
}
