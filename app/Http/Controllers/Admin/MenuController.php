<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        return MenuResource::collection(executeQuery(Menu::query()->orderBy('sort', 'asc')));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
            'name_ko'=> 'required|string',
            'status'=> 'required',
        ]);
        $slug = Str::slug($request->name, '-');
        $count = Menu::where('slug', $slug)->count();
        if($count)
            $slug = $slug.'-'.$count;

        $sort = Menu::max('sort');

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->name_ko = $request->name_ko;
        $menu->slug = $slug;
        $menu->sort = $sort+1;
        $menu->status = $request->status;
        $menu->save();

        return new MenuResource($menu);
    }


    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }


    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'=> 'required|string',
            'name_ko'=> 'required|string',
            'status'=> 'required',
        ]);

        $slug = Str::slug($request->name, '-');
        $count = Menu::where('slug', $slug)->count();
        if(($menu->slug != $slug) && ($count >= 1))
            $slug = $slug.'-'.$count;

        $menu->name = $request->name;
        $menu->name_ko = $request->name_ko;
        $menu->slug = $slug;
        $menu->status = $request->status;
        $menu->save();

        return new MenuResource($menu);
    }

    public function destroy(Menu $menu)
    {
        if(!$menu->can_delete){
            return response()->json(['success' => false, 'message' => 'Can not delete.']);
        }

        $menu->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function sortMenu(Request  $request)
    {
        $i = 1;
        foreach ($request->menu as $menu){
            $parentMenu = Menu::find($menu['id']);
            $parentMenu->sort = $i;
            $parentMenu->save();

            if($menu['subMenus']){
                $j = 1;
                foreach ($menu['subMenus'] as $sub){
                    $subcat = SubMenu::where('id', $sub['id'])->first();
                    $subcat->sort = $j;
                    $subcat->save();
                    $j++;
                }
            }

            $i++;
        }
        return MenuResource::collection(executeQuery(Menu::query()->orderBy('sort', 'asc')));
    }
}

