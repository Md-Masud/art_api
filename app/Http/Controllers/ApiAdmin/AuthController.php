<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Admin\AuthRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function createToken()
    {
        $user =User::first();
        $accessToken = $user->createToken('Token Name')->accessToken;
        return $accessToken;
    }
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required| string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);
    if ($validator->fails()) {
        return $this->RespondWithEorror('validation registration error ', $validator->errors(), 422);
    }
        try {
            $data = $this->authRepository->registerUser($request);
            return  $this->RespondWithSuccess('Registered successully !!', $data, 200);
        } catch (Exception $e) {
            return  $this->RespondWithSuccess('Registration Cannot successfull ! !!', $e->getMessage(), 400);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
           return $this->RespondWithEorror('validation registration error ', $validator->errors(), 422);
        }

            if ($this->authRepository->checkIfAuthenticated($request)) {
                $data['user'] = $user = $this->authRepository->findUserByEmailAddress($request->email);
                $data['accessToken'] = $user->createToken('authToken')->accessToken;
                return  $this->RespondWithSuccess('Logged in successully !!', $data, 200);
            }else{
                 return response()->json([
                    'error' => true,
                    'message' => 'Sorry Invalid Email and Password',
                ], 400);
            }
    }

    public function logout(Request $request)
    {
        $logout = $this->authRepository->logout($request);
        if ($logout) {
         return   $this->RespondWithSuccess('Logout in successully !!', $logout, 200);
        } else {
          return  $this->RespondWithEorror('Logout in successully !!', $logout, 400);
        }
    }

    public function change_password(Request $request){
        try{
          $data=$this->authRepository->changePassword($request);
          return  $this->RespondWithSuccess('Password Change in successully !!', $data, 200);
        }catch(Exception $e){
            return  $this->RespondWithEorror('Password Change Not successully !!', '', 400);
        }
    }
}
