<?php

namespace Modules\Kino\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Kino\Models\Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->words(rand(1, 2), true);

        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => fake()->paragraph(1),
        ];
    }

    public function notActive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
