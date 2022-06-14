<?php

namespace Database\Factories;

use App\Models\Gender;
use App\Models\FamilyType;
use App\Models\Occupation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'first_name' =>$this->faker->firstName(),
            'last_name'=>$this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'dob' => $this->faker->dateTimeBetween('-60 years','-18 years'),
            'gender_id' => Gender::pluck('id')->random(),
            'annual_income' => $this->faker->numberBetween(100000, 2000000),
            'occupation_id'  => Occupation::pluck('id')->random(),
            'family_type_id' => FamilyType::pluck('id')->random(),
            'manglik'     => $this->faker->randomElement(['Yes', 'No']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
