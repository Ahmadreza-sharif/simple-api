<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = ['female','male','others'];
        return [
            'name' => $this->faker->name,
            'lastName' => $this->faker->lastName(),
            'gender' => $gender[rand(0,2)],
            'age' => rand(18,50),
            'city' => $this->faker->city(),
            'email' => $this->faker->email()
        ];
    }
}
