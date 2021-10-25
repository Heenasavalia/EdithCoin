<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CoinpaymentTransactions;

class VerifyCoinpaymentPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Coinpayment:Verify_coin_payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coinpayment Payment Verification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $coinPaymentdata = CoinpaymentTransactions::where('status', '0')->pluck('txn_id')->toArray();
        if (count($coinPaymentdata) > 0) {
            $req['cmd'] = 'get_tx_info_multi';
            $req['version'] = 1;
            $req['key'] = env('COINPAYMENT_PUBLIC_KEY');
            $req['txid'] = implode('|', $coinPaymentdata);

            // Generate the query string
            $post_data = http_build_query($req, '', '&');

            // Calculate the HMAC signature on the POST data
            $hmac = hash_hmac('sha512', $post_data, env('COINPAYMENT_PRIVATE_KEY'));

            static $ch = NULL;
            if ($ch === NULL) {
                $ch = curl_init('https://www.coinpayments.net/api.php');
                curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            // Execute the call and close cURL handle
            $data = curl_exec($ch);
            $response = json_decode($data);

            foreach ($response->result as $key => $res) {
                CoinpaymentTransactions::where('status', '0')->where('txn_id', $key)->update(['status' => $res->status]);
            }
        }
    }
}
