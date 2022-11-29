<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\Admin\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthInterface
{
    public function checkIfAuthenticated(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return true;
        }
        return false;
    }

    public function registerUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return $user;
    }

    public function findUserByEmailAddress($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function findUserGet($id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }
    public function logout(Request $request)
    {
        return $request->user()->token()->revoke();
    }
    public function changePassword(Request $request)
    {
        $user = $this->findUserGet(Auth::id());
        if (Hash::check($request->old_password, $user->password)) {
            $change_password = User::find(Auth::id());
            $change_password->password = Hash::make($request->new_password);
            $change_password->save();
        }
        return  $change_password;
    }
}
