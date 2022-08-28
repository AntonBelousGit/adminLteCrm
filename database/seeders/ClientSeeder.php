<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Client::factory(10000)->make();

        $chunks = $posts->chunk(2000);

        $chunks->each(function ($chunk) {
            Client::insert($chunk->toArray());
        });
    }
}
