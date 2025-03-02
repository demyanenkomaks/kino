<?php

namespace Modules\Kino\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Kino\Models\Country::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(2);

        return [
            'name' => rtrim($title, '.'),
            'slug' => Str::slug($title),
        ];
    }
}
