<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private  $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
      $this->productRepository=$productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=$this->productRepository->getProductOfIndex();
            return $this->RespondWithSuccess('All product list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All product list not show successfull !!',$e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation category error ', $validator->errors(), 422);
        }
        try{
            $data=$this->productRepository->storeProduct($request);
            return $this->RespondWithSuccess('Product create successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Product not create successfull',$e->getMessage(),400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data=$this->productRepository->getProductId($id);
            return $this->RespondWithSuccess('Show product successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show product successfull',$e->getMessage(),400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'unique:products,name,'.$id,

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation product error ', $validator->errors(), 422);
        }
        try{
            $data=$this->productRepository->updateProduct($request,$id);
            return $this->RespondWithSuccess('Product update successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Product not update successfull',$e->getMessage(),400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data=$this->productRepository->deleteProduct($id);
            return $this->RespondWithSuccess('Product delete successfull !!',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Product not successfull',$e->getMessage(),400);
        }
    }
}
