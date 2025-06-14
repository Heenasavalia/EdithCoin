<?php

namespace App\Http\Controllers\ClientAuth;

use App\AffiliateBonus;
use App\Client;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/client/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'client_name' => 'required|unique:clients',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Client
     */
    protected function create(array $data)
    {
        // dd($data);

        if ($data['sponsor_id'] != null) {
            $sponsor_id = $data['sponsor_id'];
        } else {
            $sponsor_id = "EDT123890";
        }
        $unique_id = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3) . mt_rand(100000, 999999);
        $client =  Client::create([
            'first_name' => ucfirst(strtolower($data['first_name'])),
            'last_name' => ucfirst(strtolower($data['last_name'])),
            'sponsor_id' => $sponsor_id,
            'unique_id' => $data['unique_id'],
            'email' => $data['email'],
            'client_name' => $data['client_name'],
            'password' => bcrypt($data['password']),
        ]);
        if($client){
            $affiliate = AffiliateBonus::create([
                'client_id' => $client->id
            ]);
        }

        return $client;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        // dump("page run");

        $data = $request->all();
        $sponsor = (isset($data['sponsor_id'])) ? $data['sponsor_id'] : "000000000";
        // dd($sponsor);
        return view('client.auth.register',['sponsor' => $sponsor]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('client');
    }
}
