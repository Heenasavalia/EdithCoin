<?php

namespace App\Console\Commands;

use App\Client;
use Illuminate\Console\Command;

class MiningToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Mining:Mining_token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mining token proccess';

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
        $minig_data = Client::where('status','Active')->get();
        foreach($minig_data as $md){
            Client::where('status','Active')->update(['is_mining' => "0"]);
        }
    }
}
