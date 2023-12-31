<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence,
            'status' => 'ATIVO',
            'pessoa_tipo'=>'FISICA',
            'cpf' => '15192206006',
            'cnpj'=>'44737254000162'
        ];
    }
}
