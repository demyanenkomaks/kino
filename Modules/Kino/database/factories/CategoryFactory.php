<?php

namespace Modules\Kino\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Kino\Models\Category;
use Random\RandomException;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Category::class;

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
            'title' => $title,
            'description' => fake()->paragraph(1),
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
