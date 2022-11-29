<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Repositories\Admin\CategoryInterface;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryRepository implements CategoryInterface
{
    public function getCategoryOfIndex()
    {
        return $categories = Category::all();
    }
    public function  Storecategory(Request $request)
    {

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        if ($request->images) {
            $thumbnail = $request->images;
            $photoname = time() . '.' . $request->name . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/category/' . $photoname);
            $category->images = $photoname; // public/files/product/plus-point.jpg
        }
        $category->description = $request->description;
        $category->save();
        return  $category;
    }

    public function getCategoryId($id)
    {
        return $user = Category::find($id);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->status = $request->status;
        if ($request->images) {
            if (!$category->images == null) {
                unlink(public_path('files/category/' . $category->images));
            }
            $thumbnail = $request->images;
            $photoname = time() . '.' . $request->name . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/category/' . $photoname);
            $category->images = $photoname; // public/files/product/plus-point.jpg
        }
        $category->description = $request->description;
        $category->save();
        return $category;
    }
    public function deleteCategory($id)
    {

        $category =Category::findOrFail($id);

        if (!$category->images == NULL){
            unlink(public_path('files/category/' .$category->images));
            return  Category::destroy($id);
        }

    }
    public function getCategoryIdAllProduct($id){
        return $user = Category::with('products')->find($id);
    }
}
