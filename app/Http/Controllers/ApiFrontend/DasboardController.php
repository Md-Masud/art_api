<?php

namespace App\Http\Controllers\ApiFrontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\PostRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Admin\CategoryRepository;
use Exception;

class DasboardController extends Controller
{
    private  $postRepository;
    private $productRepository;
    private $categoryRepository;
    public function __construct(PostRepository $postRepository, ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
      $this->postRepository=$postRepository;
      $this->productRepository=$productRepository;
      $this->categoryRepository=$categoryRepository;
    }
    public function post(){

        try{
            $data=$this->postRepository->getPostOfIndex();
            return $this->RespondWithSuccess('All post list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All post list not show successfull !!',$e->getMessage(), 400);
        }
    }
    public function category(){
        try{
            $data=$this->categoryRepository->getCategoryOfIndex();
            return $this->RespondWithSuccess('All category list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All category list not show successfull !!',$e->getMessage(), 400);
        }

    }
    public function product(){
        try{
            $data=$this->productRepository->getProductOfIndex();
            return $this->RespondWithSuccess('All product list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All product list not show successfull !!',$e->getMessage(), 400);
        }
    }
    public function getCategoryIdAllProduct($id){
        try{
            $data=$this->categoryRepository->getCategoryIdAllProduct($id);
            return $this->RespondWithSuccess('show category successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show category successfull',$e->getMessage(),400);
        }
    }
}
