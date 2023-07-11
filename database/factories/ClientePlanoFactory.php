<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientePlano>
 */
class ClientePlanoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'=>$this->faker->sentence,
            'status'=>$this->faker->sentence,
            'valor'=>rand(1,115)-(rand(0,99)/100)
        ];
    }
}
