<?php

namespace App\Http\Controllers;

use App\AffiliateBonus;
use App\Client;
use App\Token;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function createAffiliateBonus()
    {
        $all_client = Client::where('status', 'Active')->get();
        foreach ($all_client as $c) {
            $update = AffiliateBonus::create([
                'client_id' => $c->id
            ]);
        }
        dump("done");
    }

    public function AllAffiliateIncome()
    {
        $all_client = Client::where('status', 'Active')->get();
        $token = Token::get();
        $affiliate_bouns = AffiliateBonus::get();
        foreach ($all_client as $c) {
            $token = Token::where('client_id', $c->id)->get()->sum('affiliate_income');
            $update = AffiliateBonus::where('client_id',$c->id)->update([
                'affiliate_amount' => $token
            ]);
            dump($c->id);
            dump("---upd---");
        }
        dd("Stop here");
    }


    public function check_client_name($username)
    {
        // dump($username);
        // dd($request);
        $client = Client::where('client_name', $username)->first();
        // dd($user_name->client_name);

        if ($client) {
            $client_name = $client->client_name;
        } else {
            $client_name = null;
        }
        $data = [
            'client_name' => $client_name,
        ];
        return response()->json($data);
    }

    public function ClientPasswordScriptapi()
    {
        // $clients = Client::where('id', 23)->get();
        $clients = Client::get();
        $client_password = bcrypt('123123');
        foreach ($clients as $c) {
            $c->update([
                'password' => $client_password,
            ]);
            dump($c->id);
        }
    }

    public function getspid($sponsor_id)
    {
        $user = Client::where('unique_id', $sponsor_id)->first();
        if ($user) {
            $sponsor_id = $user->unique_id;
        } else {
            $sponsor_id = null;
        }
        $data = [
            'sponsor_id' => $sponsor_id,
        ];
        return response()->json($data);
    }

    public function UserName()
    {
        $n = 0;
        $al = [
            'A', 'B', 'C', 'D', 'E',
            'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '2', '3', '4', '5', '6', '7', '8', '9'
        ];


        $alt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nub = trim($alt) . mt_rand(100000, 999999);
        // $account_id = mt_rand(10000000, 99999999);
        dump($nub);

        $pass = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3) . mt_rand(100000, 999999);
        dd($pass);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
