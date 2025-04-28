<?php

namespace Modules\Kino\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Kino\Models\Country;
use Random\RandomException;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @throws RandomException
     */
    public function definition(): array
    {
        $title = fake()->words(random_int(1, 2), true);

        return [
            'name' => $title,
            'slug' => Str::slug($title),
        ];
    }

    public function notActive(): Factory
    {
        return $this->state(function () {
            return [
                'is_active' => false,
            ];
        });
    }
}
