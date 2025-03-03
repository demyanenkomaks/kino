<?php

namespace Modules\Kino\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kino\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::factory()
            ->count(20)
            ->create();
    }
}
