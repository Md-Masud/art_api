<?php

namespace App\Http\Controllers\ApiAdmin;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserRepository;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
      $this->userRepository=$userRepository;
    }

    public function index(){
        try{
            $data=$this->userRepository->getUserOfIndex();
            return $this->RespondWithSuccess('All user list show successfull',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('All user list not show successfull !!',$e->getMessage(), 400);
        }
    }
    public function edit($id){
        try{
            $data=$this->userRepository->getUserId($id);
            return $this->RespondWithSuccess('show user successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('not show user successfull',$e->getMessage(),400);
        }
    }
    public function update(Request $request ,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required| string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation registration error ', $validator->errors(), 422);
        }
        try{
            $data=$this->userRepository->updateUser($request,$id);
            return $this->RespondWithSuccess('User update successfull !! ',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('User not update successfull',$e->getMessage(),400);
        }
    }
    public function delete($id){
        try{
            $data=$this->userRepository->deleteUser($id);
            return $this->RespondWithSuccess('User delete successfull !!',$data,200);
        }catch(Exception $e){
            return $this->RespondWithEorror('User not successfull',$e->getMessage(),400);
        }

    }
}
