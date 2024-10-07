<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{
    public function getMenus()
    {
        $menus = Menu::where('status', 1)->with('submenus')->get();

        $submenu1 = new SubMenu();
        $submenu1->id = rand(10,1000);
        $submenu1->name = App::isLocale('en') ? 'News' : '뉴스';
        $submenu1->name_en = 'News';
        $submenu1->name_ko = '뉴스';
        $submenu1->menu_id = 100;
        $submenu1->slug = '/community/news';
        $submenu1->sort = 100;
        $submenu1->status = 1;
        $submenu1->can_delete = 1;
        $submenu1->route = '/community/news';

        $submenu2 = new SubMenu();
        $submenu2->id = rand(10,1000);
        $submenu2->name = App::isLocale('en') ? 'Gallery' : ' 갤러리 ';
        $submenu2->name_en = 'Gallery';
        $submenu2->name_ko = ' 갤러리 ';
        $submenu2->menu_id = 101;
        $submenu2->slug = '/community/gallery';
        $submenu2->sort = 101;
        $submenu2->status = 1;
        $submenu2->can_delete = 1;
        $submenu2->route = '/community/gallery';

        $menus->last()->submenus->push($submenu1);
        $menus->last()->submenus->push($submenu2);

        // return $menus;

        return MenuResource::collection($menus);
    }
}
