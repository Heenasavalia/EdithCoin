<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function getspid($sponsor_id)
    {
        $user = Client::where('sponsor_id', $sponsor_id)->first();
        if ($user) {
            $sponsor_id = $user->sponsor_id;
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

        $pass = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3). mt_rand(100000, 999999);
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
