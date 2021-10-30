<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Withdrawn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.token.withdraw');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $client = Auth::user();
        // dump($client);
        // dd($data);

        $one_token_price = Helpers::getonetokenprice($client->created_at);
        $plan = "token";

        // if ($plan == "token") {
        //     $no_of_token = $data['no_of_token'];
        //     $total_amount = $no_of_token * $one_token_price;
        // } else {
        //     $amount = $data['withdraw_amount'];
        //     $no_of_token = $amount / $one_token_price;
        //     $total_amount = $amount;
        //     unset($data['amount']);
        // }



        // payment gateway

        $data['client_id'] = $client->id;
        // $data['withdraw_amount'] = $no_of_token;
        // $data['withdraw_address'] = number_format($total_amount, 2);


        // dd($data);
        $withdrawn = Withdrawn::create($data);

        if ($withdrawn) {
            return redirect()->back()->with('success', 'Insert success.');
        } else {
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
}
