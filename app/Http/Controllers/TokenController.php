<?php

namespace App\Http\Controllers;

use App\AffilateIncome;
use App\AffiliateBonus;
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

use  Detection\MobileDetect;



class TokenController extends Controller
{
    public function AffiliateHistory()
    {
        $me = Auth::user();
        $my_direct = Client::where('sponsor_id', $me->unique_id)->pluck('email')->toArray();
        $income_done = CoinpaymentTransaction::whereIn('buyer_email', $my_direct)->where('status', '100')->pluck('order_id')->toArray();
        $my_income = Token::with('client')->whereIn('token_order_id', $income_done)->get();
        $detect = new MobileDetect;
        if ($detect->isMobile()) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return view('client.affiliate_history', ['my_income' => $my_income, 'affiliate_income' => $my_income->sum('affiliate_income'), 'is_mobile' => $is_mobile]);
    }

    public function my_minig_tokens()
    {
        $payment_token =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->sum('amount_total_fiat');
        $one_token_price = Helpers::getonetokenprice(Auth::user()->created_at);
        $amount = $payment_token;
        $all_tokens = $amount / $one_token_price;
        $total_mining_token = ($all_tokens * 20 / 100) / 60;
        $total_token = number_format((float)$total_mining_token, 6, '.', '');
        return response()->json($total_token);
    }

    public function affilates()
    {
        $client = Auth::user();
        $my_directs = Client::where('sponsor_id', $client->unique_id)->where('status', 'Active')->orderBy('created_at', 'DESC')->get();
        $detect = new MobileDetect;
        if ($detect->isMobile()) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return view('client.affilates', ['my_directs' => $my_directs, 'is_mobile' => $is_mobile]);
    }

    public function getaffilatesusers(Request $request)
    {
        $id = $request->all()['client_id'];
        $me = Client::where('id', $id)->first();
        $data = Client::where('sponsor_id', $me->unique_id)->where('status', 'Active')->get();
        return datatables::of($data)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemainingToken()
    {
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

        $total_amt = Token::where('client_id', Auth::user()->id)->sum('total_amount');
        // $tokens = Token::where('client_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        $tokens =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->orderBy('id', 'DESC')->get();

        $me = Auth::user();
       
        $bonus_purchase = Token::where('client_id', $me->id)->where('is_bonus', '1')->sum('no_of_token');
        $total = $all_tokens + $all_tokens_mining + $bonus_purchase;
        $income_done = CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->pluck('order_id')->toArray();

        $detect = new MobileDetect;
        if ($detect->isMobile()) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        $me = Auth::user();
        $my_direct = Client::where('sponsor_id', $me->unique_id)->pluck('email')->toArray();
        $income_done = CoinpaymentTransaction::whereIn('buyer_email', $my_direct)->where('status', '100')->pluck('order_id')->toArray();
        $my_income_new = Token::with('client')->whereIn('token_order_id', $income_done)->sum('affiliate_income');
        // dd($tokens->sum('$tokens'));
        return view('client.home', [
            // 'my_token' => number_format((float)$my_token, 6, '.', ''),
            'all_tokens' => number_format((float)$all_tokens, 6, '.', ''),
            'all_tokens_mining' =>  number_format((float)$all_tokens_mining, 6, '.', ''),
            'total' => number_format((float)$total, 6, '.', ''),
            'total_amt' => $total_amt,
            'tokens' => $tokens,
            // 'my_income' => $my_income,
            'is_mobile' => $is_mobile,
            'my_income_new' => $my_income_new,
            'bonus_purchase' => number_format((float)$bonus_purchase, 6, '.', ''),

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
        $detect = new MobileDetect;
        if ($detect->isMobile()) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return view('client.token.create', ['is_mobile' => $is_mobile]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request);
        $data = $request->all();
        // dd($data);
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
        // dd($total_amount);
        // payment gateway
        $data['client_id'] = $client_id;
        $data['no_of_token'] = $no_of_token;
        $data['total_amount'] = number_format($total_amount, 2);
        $data['one_token_price'] = (float)$one_token_price;
        $data['is_mining'] = 0;
        // dd($data['total_amount']);
        if ($data['is_bonus'] == 1) {
            $get_my_balance = AffiliateBonus::where('client_id', $client_id)->first();
            // ->sum('affiliate_amount') $my_income->sum('affiliate_income')
            if ($get_my_balance->affiliate_amount > 1) {
                if ($total_amount < $get_my_balance->affiliate_amount) {
                    $data['is_bonus'] = '1';
                    $cut_balance = $get_my_balance->update([
                        'affiliate_amount' => $get_my_balance->affiliate_amount - number_format($total_amount, 2)
                    ]);
                    $token = Token::create($data);
                    if ($token) {
                        if ($client_id != 1) {
                            $income = Helpers::AffilateIncomeCalculate($client, $no_of_token, $token->id, $total_amount);
                        }
                        return redirect()->back()->with('success', 'Successfully Purchase done.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Oops, you do not have sufficient balance to complete this operation');
                }
            } else {
                return redirect()->back()->with('error', 'Oops, you do not have sufficient balance to complete this operation');
            }
        }
        $token = Token::create($data);
        if ($token) {
            // payment
            if ($client_id != 1) {
                $income = Helpers::AffilateIncomeCalculate($client, $no_of_token, $token->id, $total_amount);
            }

            $transaction = Helpers::payement($total_amount, $plan, $client->name, $client->email, $one_token_price, $no_of_token, $token->id, $client->created_at);
            $remove_token = CountToken::first();
            if ($remove_token) {
                $min = $remove_token->total_count - $no_of_token;
                $num = number_format((float)$min, 6, '.', '');
                $update = $remove_token->update(['total_count' => $num]);
            }
            return Redirect::to($transaction);
        } else {
            // dd("fail");
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
        $my_tokens = Token::where('client_id', $client->id)->where('is_mining', 1)->get();
        // dd($my_token);
        $detect = new MobileDetect;
        if ($detect->isMobile()) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return view('client.token.process_mining', ['mining' => $mining, 'my_tokens' => $my_tokens, 'is_mobile' => $is_mobile]);
    }


    public function processminingtoken(Request $request)
    {


        $data = $request->all();
        $client_id = Auth::user()->id;
        $client = Auth::user();


        $all_token_yet =  CoinpaymentTransaction::where('buyer_email', Auth::user()->email)->where('status', '100')->sum('amount_total_fiat');

        if ($all_token_yet == 0 || $all_token_yet == '0') {
            return redirect()->back()->with('error', 'Please create at least one Token.');
        } else {
            // dd($all_token_yet);
            $one_token_price = Helpers::getonetokenprice($client->created_at);
            $no_of_token = $all_token_yet / $one_token_price;
            $total_mining_token = ($no_of_token * 20 / 100) / 60;

            $total_amount = $total_mining_token * $one_token_price;

            $data['client_id'] = $client_id;
            $data['no_of_token'] = number_format((float)$total_mining_token, 6, '.', '');
            $data['total_amount'] = number_format($total_amount, 2);
            $data['one_token_price'] = (float)$one_token_price;
            $data['is_mining'] = 1;

            $currentDateTime = \Carbon\Carbon::now();
            $newDateTime = $currentDateTime->modify("+24 hours");
            $expired_at = \Carbon\Carbon::parse($newDateTime->format("Y-m-d H:i:s"));

            $data['expired_at'] = $expired_at;

            $token = Token::create($data);
            if ($token) {
                $upd = Client::where('id', $client_id)->update(['is_mining' => "1"]);
            }
            $remove_token = CountToken::first();
            if ($remove_token) {
                $min = $remove_token->total_count - $total_mining_token;
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
        if ($plan == "token") {
            $no_of_token = $value;
            $result = $no_of_token * $one_token_price;
        } else {
            $amount = $value;
            $result = $amount / $one_token_price;
        }
        $data = [
            'result' => $result
        ];
        return response()->json($data);
    }
}
