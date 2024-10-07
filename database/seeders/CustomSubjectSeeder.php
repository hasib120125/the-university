<?php

namespace Database\Seeders;

use App\Models\CustomSubject;
use Illuminate\Database\Seeder;

class CustomSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            '조직신학',
            '구약학',
            '신약학',
            '교회사',
            '선교학',
            '실천신학',
            '헬라어/히브리어',
            '교회음악',
            '상담학',
            '교육학'
        ];

        foreach ($subjects as $subject) {
            CustomSubject::create([
                'name'=> $subject
            ]);
        }
    }
}
