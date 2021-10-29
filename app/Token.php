<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = "tokens";
    protected $fillable = [
        'client_id', 'plan', 'no_of_token', 'total_amount', 'one_token_price', 'is_mining', 'expired_at'
    ];

    public function client()
    {
        return $this->hasOne('App\Client', 'id', 'client_id');
    }

    public function affilate()
    {
        return $this->hasOne('App\AffilateIncome', 'id', 'client_id');
    }
}
