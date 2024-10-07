<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(){
        return CategoryResource::collection(executeQuery(Category::query()));
    }

    public function addCategory(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $parentID  = 0;
        if ($request->parentID != "0")
            $parentID = $request->parent_category;

        if($parentID == 0){
            $sort = 1;
            $category = Category::orderBy('sort', 'desc')->first();

            if ($category)
                $sort = $category->sort + 1;

            Category::create([
                'name' => $request->name,
                'sort' => $sort,
                'status' => $request->status,
            ]);
        }else{
            $sort = 1;
            $category = Category::find($request->parent_category);
            $subCategory = $category->subCategories()->orderBy('sort', 'desc')->first();

            if ($subCategory)
                $sort = $subCategory->sort + 1;


            $category->subCategories()->save(
                new SubCategory([
                    'name' => $request->name,
                    'sort' => $sort,
                    'status' => $request->status,
                ])
            );
        }

        return new CategoryResource($category);
    }

    public function categoryEdit(Request $request, $id) {
        return $request;
        $ids = explode('_', $request['id']);
        if($ids[0] == 'p'){
            $category = Category::find($ids[1]);
            return new CategoryResource($category);
        }else{
            $subCategory = Category::find($request->parent)->subCategories()->find($ids[1]);

            return new CategoryResource($subCategory);
        }
    }

    public function updateCategory(Request $request) {
        $request->validate([
            'category_name' => 'required'
        ]);

        $ids = explode('_', $request->categoryId);

        if ($ids[0] == 'p') {
            $category = Category::find($ids[1]);

            if ($request->parent_category == null) {
                $category->name = $request->category_name;
                $category->status = $request->status;
                $category->save();
            } else {
                $parent = Category::find($request->parent_category);
                $sort = $parent->subCategories()->max('sort') + 1;

                $parent->subCategories()->save(
                    new SubCategory([
                        'name' => $request->category_name,
                        'sort' => $sort,
                        'status' => $request->status,
                    ])
                );

                $category->delete();
            }
        } elseif ($ids[0] == 's') {
            $parent = Category::find($request->parentId);
            $subCategory = $parent->subCategories()->find($ids[1]);

            if ($request->parent_category == null) {
                $sort = Category::max('sort') + 1;

                Category::create([
                    'name' => $request->category_name,
                    'sort' => $sort,
                    'status' => $request->status,
                ]);

                $subCategory->delete();
            } elseif ($parent->id == $request->parent_category) {
                $subCategory->name = $request->category_name;
                $subCategory->status = $request->status;
                $subCategory->save();
            } else {
                $category = Category::find($request->parent_category);
                $sort = $category->subCategories()->max('sort') + 1;
                $category->subCategories()->save(
                    new SubCategory([
                        'en_name' => $request->category_name,
                        'ko_name' => $request->category_name_korean,
                        'sort' => $sort,
                        'status' => $request->status,
                    ])
                );

                $subCategory->delete();
            }
        }

        return new CategoryResource($category);
    }

    public function sortCategory(Request $request) {
        $ids = explode('_', $request->items[0]);

        if ($ids[0] == 's') {
            $parent = Category::find($request->parent[0]);
            for($i=1; $i <= count($request->items); $i++) {
                $id = explode('_', $request->items[$i-1])[1];

                $parent->subCategories()->find($id)->update(['sort' => $i]);
            }
        } else {
            for($i=1; $i <= count($request->items); $i++) {
                $id = explode('_', $request->items[$i-1])[1];

                Category::find($id)->update(['sort' => $i]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Successfully sort updated.']);
    }

    public function deleteCategory(Request $request) {

        $ids = explode('_', $request['id']);

        if($ids[0] == 'p'){
            Category::find($ids[1])->delete();
        }else{
            Category::find($request->parent)->subCategories()->find($ids[1])->delete();
        }

        return response()->json(['success' => true, 'message' => 'Successfully deleted']);
    }
}
