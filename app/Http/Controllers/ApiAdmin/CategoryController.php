<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    private  $categoryRepository;
   public function __construct(CategoryRepository $categoryRepository)
   {
     $this->categoryRepository=$categoryRepository;
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=$this->categoryRepository->getCategoryOfIndex();
            return $this->RespondWithSuccess('All category list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All category list not show successfull !!',$e->getMessage(), 400);
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
            'name' => 'required| unique:categories',

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation category error ', $validator->errors(), 422);
        }
        try{
            $data=$this->categoryRepository->Storecategory($request);
            return $this->RespondWithSuccess('Category create successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Category not create successfull',$e->getMessage(),400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data=$this->categoryRepository->getCategoryId($id);
            return $this->RespondWithSuccess('show category successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show category successfull',$e->getMessage(),400);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$id,

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation category error ', $validator->errors(), 422);
        }
        try{
            $data=$this->categoryRepository->updateCategory($request,$id);
            return $this->RespondWithSuccess('Category update successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Category not update successfull',$e->getMessage(),400);
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
            $data=$this->categoryRepository->deleteCategory($id);
            return $this->RespondWithSuccess('Category delete successfull !!',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Category not successfull',$e->getMessage(),400);
        }
    }
}
