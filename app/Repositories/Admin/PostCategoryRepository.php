<?php

namespace App\Repositories\Admin;

use App\Models\PostCategory;
use App\Repositories\Admin\PostCategoryInterface;
use Illuminate\Http\Request;

class PostCategoryRepository implements PostCategoryInterface
{
    public function  getPostCategoryOfIndex()
    {
        return $postCategory = PostCategory::all();
    }
    public function  storePostCategory(Request $request)
    {
        $data = new PostCategory();
        $data->post_category_name = $request->post_category_name;
        $data->status = $request->status;
        $data->post_category_description= $request->post_category_description;
        $data->save();
        return  $data;
    }

    public function getPostCategoryId($id)
    {
        return $postCategory = PostCategory::find($id);
    }

    public function updatePostCategory(Request $request, $id)
    {
        $data = PostCategory::findOrFail($id);
        $data->post_category_name = $request->post_category_name;
        $data->status = $request->status;
        $data->post_category_description= $request->post_category_description;
        $data->save();
        return  $data;
    }
    public function deletePostCategory($id)
    {
        return  PostCategory::destroy($id);
    }
}
