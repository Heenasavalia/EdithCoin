<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinpaymentTransactions extends Model
{
    protected $table = "coinpayment_transactions";
    protected $fillable = [
         'status','updated_at'
     ];

    public function client() {
        return $this->hasOne('App\Client', 'id', 'client_id');
    }
}

