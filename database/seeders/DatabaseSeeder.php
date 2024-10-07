<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\OtherFee;
use App\Models\Professor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory(1)->create();
        Student::factory(20)->create();
        Professor::factory(1)->create();
        OtherFee::factory(1)->create();

        $this->call([
            RegistrationOpenSeeder::class,
            StaticPageSeeder::class,
            SettingSeeder::class
        ]);
    }
}
