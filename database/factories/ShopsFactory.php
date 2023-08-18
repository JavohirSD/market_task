<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shops>
 */
class ShopsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_id' => 0,
            'address'     => fake()->streetAddress(),
            'schedule'    => fake()->time(),
            'latitude'    => fake()->latitude(),
            'longitude'   => fake()->longitude(),
        ];
    }
}
