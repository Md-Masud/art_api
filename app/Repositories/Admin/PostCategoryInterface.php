<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface PostCategoryInterface
{

    public function  getPostCategoryOfIndex();

    public function storePostCategory(Request $request);

    public function getPostCategoryId($id);

    public function updatePostCategory(Request $request,$id);

    public function deletePostCategory($id);

}
