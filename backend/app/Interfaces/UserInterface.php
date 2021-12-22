<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    /**
     * @param null $id
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findUser($id = null);

}
