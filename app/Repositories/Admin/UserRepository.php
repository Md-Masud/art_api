<?php
namespace App\Repositories\Admin;
use App\Models\User;
use App\Repositories\Admin\UserInterface;
use Illuminate\Http\Request;
class UserRepository implements  UserInterface
{
    public function getUserOfIndex()
    {
        return $users=User::all();
    }

    public function getUserId($id)
    {
        return $user= User::find($id);
    }

    public function updateUser(Request $request,$id)
    {
       $user=User::find($id);
       $user->name=$request->name;
       $user->email=$user->email;
       $user->save();
       return $user;
    }
    public function deleteUser($id)
    {
       return $user=User::destroy($id);
    }

}
