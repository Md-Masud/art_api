<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\PostRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private  $postRepository;
    public function __construct(PostRepository $postRepository)
    {
      $this->postRepository=$postRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=$this->postRepository->getPostOfIndex();
            return $this->RespondWithSuccess('All post list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All post list not show successfull !!',$e->getMessage(), 400);
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
            'post_title' => 'required|unique:posts',

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation post error ', $validator->errors(), 422);
        }
        try{
            $data=$this->postRepository->storePost($request);
            return $this->RespondWithSuccess('Post create successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Post not create successfull',$e->getMessage(),400);
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
            $data=$this->postRepository->getPostId($id);
            return $this->RespondWithSuccess('Show post successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show post successfull',$e->getMessage(),400);
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
            'post_title' => 'unique:posts,post_title,'.$id,

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation posts error ', $validator->errors(), 422);
        }
        try{
            $data=$this->postRepository->updatePost($request,$id);
            return $this->RespondWithSuccess('Post update successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Post not update successfull',$e->getMessage(),400);
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
            $data=$this->postRepository->deletePost($id);
            return $this->RespondWithSuccess('Post delete successfull !!',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('Post not successfull',$e->getMessage(),400);
        }
    }
}
