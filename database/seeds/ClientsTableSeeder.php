<?php

use Illuminate\Database\Seeder;
use App\Dashboard\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = ['client one', 'client two'];

        foreach($clients as $client){
            Client::create([
                'name' => $client,
                'phone' => [ rand(100000000, 999999999) ],
                'address' => $client . ' address'
            ]);
        }
    }
}
