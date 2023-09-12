<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['hombre', 'mujer', 'no binario'];

        return [
            'uid'           => fake()->unique()->uuid(),
            'first_name'    => fake()->name(),
            'last_name'     => fake()->lastName(),
            'email'         => fake()->unique()->email(),
            'password'      => bcrypt(fake()->password()),
            'address'       => fake()->address(),
            'phone'         => fake()->phoneNumber(),
            'phone_2'       => fake()->phoneNumber(),
            'postal_code'   => fake()->postcode(),
            'birth_date'    => fake()->date(),
            'gender'        => fake()->randomElement($genders),
        ];
    }
}
