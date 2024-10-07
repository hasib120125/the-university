<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Page;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class FixedPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'slug' => 'admission-guide',
                'sub_menus' =>[
                    [
                        'title' => 'Admission Counselling',
                        'title_ko' => '입학상담',
                        'slug' => 'admission-counselling',
                    ]
                ]
            ],
            [
                'slug' => 'department-guide',
                'sub_menus' =>[
                    // [
                    //     'title' => 'Professor Instructor Introduction',
                    //     'title_ko' => '교수 강사 소개',
                    //     'slug' => 'professor-instructor-introduction',
                    // ],
                    [
                        'title' => 'Ministry Of Ministry',
                        'title_ko' => '목회학과',
                        'slug' => 'ministry-of-ministry',
                    ],
                    [
                        'title' => 'Department Of Missiology',
                        'title_ko' => '선교학과',
                        'slug' => 'department-of-missiology',
                    ],
                    [
                        'title' => 'Department Of Pastoral Music',
                        'title_ko' => 'Department Of Pastoral Music',
                        'slug' => 'department-of-pastoral-music',
                    ]
                ]
            ],
            [
                'slug' => 'academic-information',
                'sub_menus' =>[
                    [
                        'title' => 'Academic Regulation',
                        'title_ko' => '학업 규정',
                        'slug' => 'academic-regulation',
                    ]
                ]
            ],
            [
                'slug' => 'community',
                'sub_menus' => [
                    [
                        'title' => 'Icu Articles Public Relations',
                        'title_ko' => 'ICU 기사 및 홍보',
                        'slug' => 'icu-articles-public-relations',
                    ],
                    [
                        'title' => 'Offline Seminar',
                        'title_slug' => '오프라인 세미나',
                        'slug' => 'offline-seminar',
                    ],
                    [
                        'title' => 'Downloads',
                        'title_ko' => '다운로드',
                        'slug' => 'downloads',
                    ]
                ]
            ]
        ];

        foreach ($pages as $page) {
            $menu = Menu::where('slug', $page['slug'])->first();
            foreach ($page['sub_menus'] as $sub_menu) {
                $submenu = SubMenu::where('slug', $sub_menu['slug'])->first();
                $page = Page::where('menu_id', $menu->id)->where('sub_id', $submenu->id)->first();
        
                if($page){
                    $page->can_delete = false;
                    $page->save();
                }else{
                    $page = new Page();
                    $page->menu_id = $menu->id;
                    $page->sub_id = $submenu->id;
                    $page->title = $sub_menu['title'];
                    $page->title_ko = $sub_menu['title_ko'];
                    $page->description = $sub_menu['title'];
                    $page->description_ko = $sub_menu['title_ko'];
                    $page->status = 1;
                    $page->can_delete = false;
                    $page->save();
                }
            }
        }
    }
}
