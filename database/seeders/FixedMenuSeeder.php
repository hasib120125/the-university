<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class FixedMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'Admission Guide',
                'slug' => 'admission-guide',
                'sub_menus' =>[
                    [
                        'name' => 'Admission Counselling',
                        'slug' => 'admission-counselling',
                    ]
                ]
            ],
            [
                'name' => 'Department Guide',
                'slug' => 'department-guide',
                'sub_menus' =>[
                    // [
                    //     'name' => 'Professor Instructor Introduction',
                    //     'slug' => 'professor-instructor-introduction',
                    // ],
                    [
                        'name' => 'Ministry Of Ministry',
                        'slug' => 'ministry-of-ministry',
                    ],
                    [
                        'name' => 'Department Of Missiology',
                        'slug' => 'department-of-missiology',
                    ],
                    [
                        'name' => 'Department Of Pastoral Music',
                        'slug' => 'department-of-pastoral-music',
                    ]
                ]
            ],
            [
                'name' => 'Academic Information',
                'slug' => 'academic-information',
                'sub_menus' =>[
                    [
                        'name' => 'Academic Regulation',
                        'slug' => 'academic-regulation',
                    ]
                ]
            ],
            [
                'name' => 'Community',
                'slug' => 'community',
                'sub_menus' => [
                    [
                        'name' => 'Icu Articles Public Relations',
                        'slug' => 'icu-articles-public-relations',
                    ],
                    [
                        'name' => 'Offline Seminar',
                        'slug' => 'offline-seminar',
                    ],
                    [
                        'name' => 'Downloads',
                        'slug' => 'downloads',
                    ]
                ]
            ]
        ];

        foreach ($menus as $menu) {
            $menu_slug = $menu['slug'];

            $current_menu = Menu::where('slug', $menu_slug)->first();
            if($current_menu){
                $current_menu->can_delete = false;
                $current_menu->save();
            }else{
                $sort = Menu::max('sort');
                $current_menu = new Menu();
                $current_menu->name = $menu['name'];
                $current_menu->name_ko = $menu['name'];
                $current_menu->slug = $menu_slug;
                $current_menu->sort = $sort + 1;
                $current_menu->status = 1;
                $current_menu->can_delete = false;
                $current_menu->save();
            }


            foreach ($menu['sub_menus'] as $sub_menu) {

                $sub_menu_slug = $sub_menu['slug'];
                $current_sub_menu = SubMenu::where('slug', $sub_menu_slug)->first();
                if($current_sub_menu){
                    $current_sub_menu->can_delete = false;
                    $current_sub_menu->save();
                }else{
                    $sort = SubMenu::max('sort');

                    $current_sub_menu = $current_menu->submenus()->create([
                        'name' => $sub_menu['name'],
                        'name_ko' => $sub_menu['name'],
                        'slug' => $sub_menu_slug,
                        'status' => 1,
                        'sort' => $sort + 1,
                        'can_delete' => false,
                    ]);
                }
            }
        }    
    }
}
