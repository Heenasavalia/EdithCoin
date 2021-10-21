<?php

namespace App\Http;

use Illuminate\Http\Request;
use App\Token;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Hexters\CoinPayment\CoinPayment;

class Helpers
{

    public static function getonetokenprice($created_at)
    {
        $one_token_price  = 0.05;

        $mytime = \Carbon\Carbon::now();
        $date = $mytime->toDateTimeString();
        $from = \Carbon\Carbon::parse($mytime->format("Y-m-d"));
        $to = \Carbon\Carbon::parse($created_at->format("Y-m-d"));
        $diff_in_days = $to->diffInDays($from);

        if ($diff_in_days > 30) {
            $one_token_price  = 0.08;
        }
        // dd($one_token_price);
        return $one_token_price;
    }

    public static function payement($total_amount, $plan, $client_name, $client_email, $one_token_price, $no_of_token, $id = null, $created_at)
    {
        // dump($total_amount, $plan, $client_name, $client_email, $one_token_price, $no_of_token, $id = null, $created_at);
        $transaction = [];
        
        $transaction['order_id'] = uniqid(); // invoice number
        $transaction['amountTotal'] = (float) $total_amount;
        $transaction['note'] = $plan;
        $transaction['buyer_name'] = $client_name;
        $transaction['buyer_email'] = $client_email;

        $one_token_price = Helpers::getonetokenprice($created_at);
        $amount = (float) $total_amount;
        $result = $amount / $one_token_price;
        // dd($result);
        $transaction['token'] = $result;


        $transaction['redirect_url'] = url('/client/home?q=success'); // When Transaction was comleted
        // When user click cancel link
        // if($transaction['cancel_url'] = url('/client/home?q=failed')){
        //     $get = Token::where('id',$id)->delete();
        // }
        $transaction['cancel_url'] = url('/client/home?q=failed');

       
        // $update = Token::where('id',$id);
        
        // dump("------------");
        // dd($result);
        
        // $transaction['token'] = 

        $transaction['items'][] = [
            'itemDescription' => 'Token',
            'itemPrice' => (float) $one_token_price, // USD
            'itemQty' => (int) $no_of_token,
            'itemSubtotalAmount' => (float) $total_amount // USD
        ];

        $transaction['payload'] = [
            'foo' => [
                'bar' => 'baz'
            ]
        ];



        return CoinPayment::generatelink($transaction);
    }
}
