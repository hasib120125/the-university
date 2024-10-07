<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\OtherFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtherFeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OtherFee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'entrance'=> 0,
            'seminar_fees'=> 0,
            'student_union'=> 0,
            'orientation'=> 0
        ];
    }
}
