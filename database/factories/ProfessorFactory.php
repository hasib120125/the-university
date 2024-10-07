<?php

namespace Database\Factories;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Professor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_hangul' => $this->faker->name,
            'name_chinese' => $this->faker->name,
            'name_english' => $this->faker->name,
            'email' => 'professor@university.com',
            'dob' => $this->faker->dateTime(),
            'photo' => null,
            'address' => $this->faker->address,
            'department_id' => 2,
            'mobile' => $this->faker->phoneNumber(),
        ];
    }
}
