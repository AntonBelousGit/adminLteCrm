<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Company::factory(10000)->make();

        $chunks = $posts->chunk(2000);

        $chunks->each(function ($chunk) {
            Company::insert($chunk->toArray());
        });
    }
}
