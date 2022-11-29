<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use App\Repositories\Admin\ProductInterface;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductRepository implements  ProductInterface
{
    public function getProductOfIndex()
    {
        return $products =Product::with('category','sub_category')->get();
    }
    public function  storeProduct(Request $request)
    {
       // dd($request->all());
        $data = new Product();
        $data->name = $request->name;
        $slug = $data->slug = Str::slug($request->name, '-');
        $data->code = $request->code;
        $data->video = $request->video;
        $data->unit = $request->unit;
        $data->category_id = $request->category_id;
        $data->sub_category_id = $request->sub_category_id;
        $data->selling_price = $request->selling_price;
        $data->discount_price = $request->discount_price;
        $data->stock_quantity = $request->stock_quantity;
        $data->size = $request->size;
        $data->color = $request->color;
        $data->description = $request->description;
        $data->status = $request->status ? 1 : 0;
        //single thumbnail
        if ($request->thumbnail) {
            $thumbnail = $request->thumbnail;
            $photoname = time() . '.' . $slug . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/product/' . $photoname);
            $data->thumbnail = $photoname; // public/files/product/plus-point.jpg
        }
        //multiple images
        $images = [];
        $images = array();
        if($request->hasFile('images')){
            foreach ($request->file('images') as $key => $image) {
                $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
                array_push($images, $imageName);
            }
            $data['images'] = json_encode($images);
        }
        $data->save();
        return  $data;
    }

    public function  getProductId($id)
    {
        return $user = Product::find($id);
    }

    public function updateProduct(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->name = $request->name;
        $slug = $data->slug = Str::slug($request->name, '-');
        $data->code =$request->code;
        $data->category_id = $request->category_id;
        $data->sub_category_id = $request->sub_category_id;
        $data->unit = $request->unit;
        $data->selling_price = $request->selling_price;
        $data->discount_price = $request->discount_price;
        $data->stock_quantity = $request->stock_quantity;
        $data->color = $request->color;
        $data->size = $request->size;
        $data->description = $request->description;
        $data->video = $request->video;
        $data->status = $request->status ? 1 : 0;
        if ($request->thumbnail) {
            if (!$data->thumbnail == null) {
                unlink(public_path('public/files/product/' . $data->thumbnail));
            }

            $thumbnail = $request->thumbnail;
            $photoname = time() . '.' . $slug .  '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('public/files/product/' . $photoname);
            $data->thumbnail = $photoname; // public/files/product/plus-point.jpg
        }
        //multiple images
        $images = [];
        if ($request->hasFile('images')) {
            $multiimage = json_decode($data->images);
            if (!$data->images == null) {
                foreach ($multiimage as $imagee) {
                    unlink(public_path('public/files/product/' . $imagee));
                }
            }
            foreach ($request->file('images') as $key => $image) {
                $imageName = hexdec(uniqid()) . '.' .$image->getClientOriginalExtension();
                Image::make($image) ->resize(600, 600)->save('public/files/product/' . $imageName);
                array_push($images, $imageName);
            }
            $data->images = json_encode($images);
        }
        $data->save();
        return $data;
    }
    public function deleteProduct($id)
    {


        $product = Product::findOrFail($id);

        if (!$product->thumbnail == null) {
            unlink(public_path('files/product/' . $product->thumbnail));
        }
        $multiimage = json_decode($product->images);
        if (!$product->images == null) {
            foreach ($multiimage as $imagee) {
                unlink(public_path('files/product/' . $imagee));
            }
        }
      return  Product::destroy($id);
    }
}
