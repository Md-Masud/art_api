<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\PostCategoryRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class PostCategoryController extends Controller
{

    private  $postCategoryRepository;
    public function __construct(PostCategoryRepository $postCategoryRepository)
    {
      $this->postCategoryRepository=$postCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=$this->postCategoryRepository->getPostCategoryOfIndex();
            return $this->RespondWithSuccess('All postCategory list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All postCategory list not show successfull !!',$e->getMessage(), 400);
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
            'post_category_name' => 'required|unique:post_categories',

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation postCategory error ', $validator->errors(), 422);
        }
        try{
            $data=$this->postCategoryRepository->storePostCategory($request);
            return $this->RespondWithSuccess('postCategory create successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('postCategory not create successfull',$e->getMessage(),400);
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
            $data=$this->postCategoryRepository->getPostCategoryId($id);
            return $this->RespondWithSuccess('Show postCategory successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show postCategory successfull',$e->getMessage(),400);
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
            'post_category_name' => 'unique:post_categories,post_category_name,'.$id,

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation postCategory error ', $validator->errors(), 422);
        }
        try{
            $data=$this->postCategoryRepository->updatePostCategory($request,$id);
            return $this->RespondWithSuccess('PostCategory update successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('PostCategory not update successfull',$e->getMessage(),400);
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
            $data=$this->postCategoryRepository->deletePostCategory($id);
            return $this->RespondWithSuccess('PostCategory delete successfull !!',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror(' PostCategory not successfull',$e->getMessage(),400);
        }
    }
}
