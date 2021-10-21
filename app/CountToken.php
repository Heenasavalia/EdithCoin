<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountToken extends Model
{
    protected $table = "count_token";
    protected $fillable = [
        'total_count'
    ];
}
