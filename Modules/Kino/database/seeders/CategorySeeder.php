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
                Category::factory()->count(5),
                ['title' => fake()->words(rand(1, 2), true)]
            )
            ->count(3)
            ->create();
    }
}
