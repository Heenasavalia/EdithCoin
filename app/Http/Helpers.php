<?php

namespace App\Http;

use Illuminate\Http\Request;
use App\Token;
use App\Client;
use App\AffilateIncome;
use App\AffiliateBonus;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Hexters\CoinPayment\CoinPayment;

class Helpers
{
    public static function AffilateIncomeCalculate($client, $no_of_token, $id, $total_amount)
    {
        // dump("in helper");
        // dump($client, $no_of_token, $id, $total_amount);
        // dd("syp");

        $my_up_lavel = Client::where('unique_id', $client->sponsor_id)->first();

        if ($no_of_token <= 50000) {
            // dump("In 50,000");
            $total_affilate_income = ($total_amount * 5) / 100;
        } elseif ($no_of_token > 50000 && $no_of_token <= 100000) {
            // dump("In 50,000 to 1,00,000");
            $total_affilate_income = ($total_amount * 10) / 100;
        } elseif ($no_of_token > 100000 && $no_of_token <= 500000) {
            // dump("In 1,00,000 to 5,00,000");
            $total_affilate_income = ($total_amount * 15) / 100;
        } elseif ($no_of_token > 500000 && $no_of_token <= 999999) {
            // dump("In 5,00,000 to 9,99,999");
            $total_affilate_income = ($total_amount * 20) / 100;
        } else {
            // dump("last else");
            $total_affilate_income = $total_amount;
        }
        $one_token_price = Helpers::getonetokenprice($client->created_at);
        $update_income = Token::where('id', $id)->update(['affiliate_income' => $total_affilate_income]);

        $sum = Token::where('client_id',$client->id)->sum('affiliate_income');
        $upd = AffiliateBonus::where('client_id',$my_up_lavel->id)->update(['affiliate_amount'=>$sum]);
        // dd('helper stop');
        return $total_affilate_income;
    }

    public static function getonetokenprice($created_at)
    {
        $one_token_price  = 0.05;

        $mytime = \Carbon\Carbon::now();
        $date = $mytime->toDateTimeString();
        $from = \Carbon\Carbon::parse($mytime->format("Y-m-d"));
        $to = \Carbon\Carbon::parse($created_at->format("Y-m-d"));
        $diff_in_days = $to->diffInDays($from);

        // if ($diff_in_days > 30) {
        //     $one_token_price  = 0.08;
        // }
        // dd($one_token_price);
        return $one_token_price;
    }

    public static function payement($total_amount, $plan, $client_name, $client_email, $one_token_price, $no_of_token, $id = null, $created_at)
    {
        // dd($id);
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


        $update = Token::where('id', $id)->update(['token_order_id' => $transaction['order_id']]);

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
