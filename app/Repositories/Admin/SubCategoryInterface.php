<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface SubCategoryInterface
{

    public function  getSubCategoryOfIndex();

    public function storeSubCategory(Request $request);

    public function getSubCategoryId($id);

    public function updateSubCategory(Request $request,$id);

    public function deleteSubCategory($id);

}
