<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubMenuResource;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubMenuController extends Controller
{

    public function index(Menu $menu)
    {
        $menus = SubMenu::where('menu_id', $menu->id)->orderBy('sort','asc')->get();
        return SubMenuResource::collection($menus);
    }


    public function store(Request $request, Menu $menu)
    {

        $request->validate([
            'name'=> 'required|string',
            'name_ko'=> 'required|string',
            'menu_id'=> 'required',
            'status'=> 'required',
        ]);

        $slug = Str::slug($request->name, '-');
        $count = SubMenu::where('slug', $slug)->count();
        if($count)
            $slug = $slug.'-'.$count;

        $sort = SubMenu::max('sort');

        $submenu = $menu->submenus()->create([
            'name' => $request->name,
            'name_ko' => $request->name_ko,
            'slug' => $slug,
            'status' => $request->status,
            'sort' =>  $sort+1,
        ]);

        return new SubMenuResource($submenu);
    }

    public function show(Menu $menu, SubMenu $subMenu)
    {
        return new SubMenuResource($subMenu);
    }


    public function update(Request $request, Menu $menu, SubMenu $subMenu)
    {
        $request->validate([
            'name'=> 'required|string',
            'name_ko'=> 'required|string',
            'status'=> 'required',
        ]);

        $slug = Str::slug($request->name, '-');
        $count = SubMenu::where('slug', $slug)->count();
        if(($subMenu->slug != $slug) && ($count >= 1))
            $slug = $slug.'-'.$count;

        $subMenu->name = $request->name;
        $subMenu->name_ko = $request->name_ko;
        $subMenu->slug = $slug;
        $subMenu->status = $request->status;
        $subMenu->save();

        return new SubMenuResource($subMenu);
    }

    public function destroy(Menu $menu, SubMenu $subMenu)
    {
        if(!$subMenu->can_delete){
            return response()->json(['success' => false, 'message' => 'Can not delete.']);
        }

        $subMenu->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
