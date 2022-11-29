<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface PostInterface
{

    public function  getPostOfIndex();

    public function storePost(Request $request);

    public function getPostId($id);

    public function updatePost(Request $request, $id);

    public function deletePost($id);
}
