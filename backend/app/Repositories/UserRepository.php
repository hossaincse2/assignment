<?php
namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use DB;

class UserRepository implements UserInterface
{
    public function findUser($id = null)
    {
        if($id) {
            return User::where('id', $id)->get();
        }

        return User::all();
    }
}
