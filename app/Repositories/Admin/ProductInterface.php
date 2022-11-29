<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface ProductInterface
{

    public function  getProductOfIndex();

    public function storeProduct(Request $request);

    public function getProductId($id);

    public function updateProduct(Request $request,$id);

    public function deleteProduct($id);

}
