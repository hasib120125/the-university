<?php

namespace Database\Seeders;

use App\Enumeration\StaticPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$ABOUT_US,
            'title_en' => 'About Us',
            'title_ko' => '회사 소개',
            'content_en' => 'About Us',
            'content_ko' => '회사 소개',
            'slug' => Str::slug('About Us'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$TIMETABLE,
            'title_en' => 'Timetable',
            'title_ko' => '시간표',
            'content_en' => 'Timetable',
            'content_ko' => '시간표',
            'slug' => Str::slug('Timetable'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$OUR_TEACHERS,
            'title_en' => 'Our Teachers',
            'title_ko' => '우리 선생님들',
            'content_en' => 'Our Teachers',
            'content_ko' => '우리 선생님들',
            'slug' => Str::slug('Our Teachers'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$UNDERGRADUATE,
            'title_en' => 'Undergraduate',
            'title_ko' => '대학 재학생',
            'content_en' => 'Undergraduate',
            'content_ko' => '대학 재학생',
            'slug' => Str::slug('Undergraduate'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$GRADUATE,
            'title_en' => 'Graduate',
            'title_ko' => '졸업하다',
            'content_en' => 'Graduate',
            'content_ko' => '졸업하다',
            'slug' => Str::slug('Graduate'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$PROFESSIONALS,
            'title_en' => 'Professional',
            'title_ko' => '전문적인',
            'content_en' => 'Professional',
            'content_ko' => '전문적인',
            'slug' => Str::slug('Professional'),
        ]);

        DB::table('static_pages')->insert([
            'page_id' => StaticPage::$COURSES,
            'title_en' => 'Courses',
            'title_ko' => '과정',
            'content_en' => 'Courses',
            'content_ko' => '과정',
            'slug' => Str::slug('Courses'),
        ]);
    }
}
