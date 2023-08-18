<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchants>
 */
class MerchantsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'user_id' => 0,
            'name'    => $this->faker->company,
            'balance' => $this->faker->randomFloat(2, 100, 10000),
            'status'  => rand(1,2),
        ];
    }
}
