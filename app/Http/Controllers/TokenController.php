<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Token;
use App\Client;
use App\CountToken;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Helpers;
use Hexters\CoinPayment\CoinPayment;
use Sortable;
use DB;
use Carbon\Carbon;
use Hexters\CoinPayment\Entities\CoinpaymentTransaction;
use Hexters\CoinPayment\Entities\CoinpaymentTransactionItem;
use Illuminate\Support\Facades\Redirect;


class TokenController extends Controller
{

    public function affilate()
    {
        // dd("yes");
        $client = Auth::user();
        // $my_directs = Client::where('sponsor_id', $client->unique_id)->orderBy('created_at', 'DESC')->paginate(10);
        $my_directs = Client::where('sponsor_id', $client->unique_id)->where('status', 'Active')->orderBy('created_at', 'DESC')->pluck('id')->toArray();
        // dump($my_directs);

        $token = Token::with('client')->whereIn('client_id', $my_directs)->get();
        //dump($token);

        // dd($token);

        // dd($client);

        return view('client.affilate', ['token' => $token]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemainingToken()
    {
        // dd("yes");
        // $response = [
        //     'success' => 0,
        //     'messages'
        // ];
        $get_tokens = CountToken::first();
        return response()->json($get_tokens);
    }


    public function fetch_data(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $id = $request->all()['client_id'];
            if ($request->from_date != '' && $request->to_date != '') {

                $startdate = Carbon::parse($request->all()['from_date'])->format('Y-m-d H:i:s');
                $enddate = Carbon::parse($request->all()['to_date'])->format('Y-m-d H:i:s');
                $data =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->whereBetween('created_at', [$startdate, $enddate])->get();
                // $data = Token::where('client_id', $id)->whereBetween('created_at', [$startdate, $enddate])->get();
            }
            // dd($data);
            // return view('client.home', [
            //     'tokens' => $data
            // ]);
            return json_encode($data);
        }
    }


    public function index(Request $request)
    {
        // dd(Auth::user()->created_at);
        // $all_tokens = Token::where('client_id', Auth::user()->id)->where('is_mining', 0)->sum('no_of_token');
        $payment_token =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->sum('amount_total_fiat');
        $one_token_price = Helpers::getonetokenprice(Auth::user()->created_at);
        $amount = $payment_token;
        $all_tokens = $amount / $one_token_price;



        $all_tokens_mining = Token::where('client_id', Auth::user()->id)->where('is_mining', 1)->sum('no_of_token');

        $total = $all_tokens + $all_tokens_mining;
        $total_amt = Token::where('client_id', Auth::user()->id)->sum('total_amount');
        // $tokens = Token::where('client_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        $tokens =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->orderBy('id', 'DESC')->paginate(10);
        // dump($tokens->items[]);

        // $coin = CoinpaymentTransactionItem::

        return view('client.home', [
            // 'result' => $result,
            'all_tokens' => $all_tokens,
            'all_tokens_mining' => $all_tokens_mining,
            'total' => $total,
            'total_amt' => $total_amt,
            'tokens' => $tokens
        ]);
    }

    public function getalltokendata(Request $request)
    {

        $tokens = Token::where('client_id', Auth::user()->id)->get();

        // dd($tokens);
        return datatables::of($tokens)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.token.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $client_id = Auth::user()->id;
        // $client_id = 1;

        $client = Auth::user();
        // $client = Client::find($client_id);

        $plan = $data['plan'];

        $one_token_price = Helpers::getonetokenprice($client->created_at);

        if ($plan == "token") {
            $no_of_token = $data['no_of_token'];
            $total_amount = $no_of_token * $one_token_price;
        } else {
            $amount = $data['amount'];
            $no_of_token = $amount / $one_token_price;
            $total_amount = $amount;
            unset($data['amount']);
        }



        // payment gateway

        $data['client_id'] = $client_id;
        $data['no_of_token'] = (int)$no_of_token;
        $data['total_amount'] = number_format($total_amount, 2);;
        $data['one_token_price'] = (float)$one_token_price;
        $data['is_mining'] = 0;

        // dd($data);

        $token = Token::create($data);


        // $token = Token::create($data);
        if ($token) {
            // dump("it's work");
            // payment
            $transaction = Helpers::payement($total_amount, $plan, $client->name, $client->email, $one_token_price, $no_of_token, $token->id, $client->created_at);
            // print_r($transaction);
            // // dd();
            // dd($transaction);
            // dd("fail t");
            // if($transaction['cancel_url']){
            //     $get = Token::where('id',$token->id)->delete();
            // }
            // dd($transaction);
            $remove_token = CountToken::first();
            // dd($remove_token);
            if ($remove_token) {
                $min = $remove_token->total_count - $no_of_token;
                $num = number_format((float)$min, 6, '.', '');
                $update = $remove_token->update(['total_count' => $num]);
            }


            return Redirect::to($transaction);

            // return redirect('client/home')->with('success', 'Successfully Purchase done.');
        } else {
            dump("jrgh");
            dd("fail");
            return redirect()->back()->with('error', 'Oops, Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_token_record()
    {
        // dd("yes");
        $client_id = Auth::user()->id;
        $last_get =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->get();

        // $last_get = Token::where('client_id', $client_id)->latest()->first();
        if (!$last_get->isEmpty()) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }
    public function ProcessMiningPage()
    {
        // dd("yes");
        // $now = Carbon::now();
        // dd($now);   
        $client = Auth::user();
        // dump($client);
        $mining = $client->is_mining;
        // dd($mining);
        return view('client.token.process_mining', ['mining' => $mining]);

        // if($last_get != null){
        //     $expired_at = $last_get->expired_at;
        //     return view('client.token.process_mining', ['last_get' => $last_get, 'expired_at' => $expired_at]);
        //     // return redirect()->back()->with('error', 'Please create at least one Token.');
        // }else{
        //     return redirect('/client/process_mining')->with('error', 'Please create at least one Token.');
        // }

    }


    public function processminingtoken(Request $request)
    {


        $data = $request->all();
        $client_id = Auth::user()->id;
        $client = Auth::user();

        // dd("token mining");

        // return redirect()->back()->with('success', 'ccheck good');
        $all_token_yet = Token::where('client_id', $client_id)->sum('no_of_token');
        $all_token_yet =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->sum('amount_total_fiat');
        // dd($all_token_yet);
        if ($all_token_yet == 0 || $all_token_yet == '0') {
            return redirect()->back()->with('error', 'Please create at least one Token.');
        } else {
            // dd($all_token_yet);
            $mining_token_no = ($all_token_yet * 20 / 100) / 60;
            $no_of_token = $mining_token_no;

            $one_token_price = Helpers::getonetokenprice($client->created_at);
            $total_amount = $no_of_token * $one_token_price;

            $data['client_id'] = $client_id;
            $data['no_of_token'] = number_format((float)$no_of_token, 6, '.', '');
            $data['total_amount'] = number_format($total_amount, 2);
            $data['one_token_price'] = (float)$one_token_price;
            $data['is_mining'] = 1;
            $currentDateTime = \Carbon\Carbon::now();
            $newDateTime = $currentDateTime->modify("+24 hours");
            $expired_at = \Carbon\Carbon::parse($newDateTime->format("Y-m-d H:i:s"));

            $data['expired_at'] = $expired_at;

            $plan = "token";

            $token = Token::create($data);
            if ($token) {
                $upd = Client::where('id', $client_id)->update(['is_mining' => "1"]);
            }
            $plan = "token";
            $remove_token = CountToken::first();

            if ($remove_token) {
                $min = $remove_token->total_count - $mining_token_no;
                $num = number_format((float)$min, 6, '.', '');
                $update = $remove_token->update(['total_count' => $num]);
            }
            if ($token) {
                // $transaction = Helpers::payement($total_amount, $plan, $client->name, $client->email, $one_token_price, $no_of_token);
                // return Redirect::to($transaction);
                return redirect('client/home')->with('success', 'Successfully done.');
            } else {
                return redirect()->back()->with('error', 'Oops, Something went wrong.');
            }
        }
    }


    public function getamttoken($type, $value)
    {
        $plan = $type;

        $client = Auth::user();

        $one_token_price = Helpers::getonetokenprice($client->created_at);
        // dd($one_token_price);

        if ($plan == "token") {
            $no_of_token = $value;
            $result = $no_of_token * $one_token_price;
        } else {
            $amount = $value;
            $result = $amount / $one_token_price;
            // $total_amount = $amount;
        }

        $data = [
            'result' => $result
        ];

        return response()->json($data);
    }
}
