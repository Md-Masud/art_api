<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface CategoryInterface
{

    public function  getCategoryOfIndex();

    public function Storecategory(Request $request);

    public function getCategoryId($id);

    public function updateCategory(Request $request,$id);

    public function deleteCategory($id);

}
