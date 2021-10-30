<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawn extends Model
{
    protected $table="withdrawn";
    protected $fillable = [
        'client_id','withdrawn_txt_id','withdrawn_address','withdrawn_amount','withdrawn_token'
    ];
}
