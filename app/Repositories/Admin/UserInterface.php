<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;

interface UserInterface
{

    public function  getUserOfIndex();

    public function getUserId($id);

    public function updateUser(Request $request,$id);

    public function deleteUser($id);

}
