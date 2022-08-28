<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $companies = collect(Company::all()->modelKeys());
        $clients = collect(Client::all()->modelKeys());

        for ($i = 0; $i < 20000; $i++) {
            $data[] = [
                'client_id' => $clients->random(),
                'company_id' => $companies->random(),
            ];
        }

        $chunks = array_chunk($data, 2000);
        foreach ($chunks as $chunk)
        {
         DB::table('client_company')->insert($chunk);
        }
    }
}
