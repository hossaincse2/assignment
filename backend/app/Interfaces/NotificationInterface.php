<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface NotificationInterface
{
    /**
     * @param null $id
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findNotification($id = null);

}
