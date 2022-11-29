<?php

namespace App\Repositories\Admin;

use App\Models\SubCategory;
use App\Repositories\Admin\SubCategoryInterface;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SubCategoryRepository implements SubCategoryInterface
{
    public function getSubCategoryOfIndex()
    {
        return $sub_categories = SubCategory::with('category')->get();
    }
    public function  StoreSubCategory(Request $request)
    {

        $data = new SubCategory();
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        if ($request->image) {
            $thumbnail = $request->image;
            $photoname = time() . '.' . $request->name . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/subcategory/' . $photoname);
            $data->image = $photoname; // public/files/product/plus-point.jpg
        }
        $data->description = $request->description;
        $data->save();
        return  $data;
    }

    public function getSubCategoryId($id)
    {
        return $sub_categorie = SubCategory::find($id);
    }

    public function updateSubCategory(Request $request, $id)
    {
        $data = SubCategory::find($id);
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        if ($request->image) {
            if (!$data->image == null) {
                unlink(public_path('files/subcategory/' . $data->images));
            }
            $thumbnail = $request->image;
            $photoname = time() . '.' . $request->name . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/subcategory/' . $photoname);
            $data->image = $photoname; // public/files/product/plus-point.jpg
        }
        $data->description = $request->description;
        $data->save();
        return  $data;
    }
    public function deleteSubCategory($id)
    {

        $data = SubCategory::findOrFail($id);

        if (!$data->image == NULL) {
            unlink(public_path('files/subcategory/' . $data->image));
            return  SubCategory::destroy($id);
        }
    }
}
