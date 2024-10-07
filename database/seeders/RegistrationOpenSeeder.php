<?php

namespace Database\Seeders;

use App\Enumeration\StaticPage;
use App\Models\RegistrationOpen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationOpenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegistrationOpen::create([
            'semester_id'=> '1',
            'start_date'=> '2021-06-02',
            'end_date'=> '2021-06-12',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
