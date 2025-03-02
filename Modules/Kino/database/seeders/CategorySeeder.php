<?php

namespace Modules\Kino\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kino\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->hasAttached(
                Category::factory()->count(10),
                ['title' => fake()->sentence(2)]
            )
            ->count(3)
            ->create();
    }
}
