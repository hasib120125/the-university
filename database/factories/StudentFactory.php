<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'student_no' => 'LY2021',
            'name_hangul' => $this->faker->name,
            'name_chinese' => $this->faker->name,
            'name_english' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('123456'), // password
            'address' => $this->faker->address,
            'department_id' => 1,
            'semester_id' => 1,
            'citizenship_no' => 'NY2021',
            'dob' => $this->faker->dateTime(),
            'mobile' => $this->faker->phoneNumber(),
            'last_education_start' => $this->faker->dateTime(),
            'last_education_end' => $this->faker->dateTime(),
            'last_school_name' => 'University of Oxford',
            'graduate_plan' => 'NA',
            'last_education_department' => 'CSE',
            'last_education_special' => 'Data Structure',
            'motive' => 'NA',
            'job_company' => $this->faker->company,
            'job_position' => 'Programmer',
            'job_address' => $this->faker->address,
            'status' => 1,
            'degree_number' => 'LY12021',
            'admission_date' => $this->faker->dateTime(),
            'admit_status' => 1,
            'bible_exam' => 1,
            'remember_token' => null
        ];
    }
}
