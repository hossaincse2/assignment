<?php
namespace App\Repositories;

use App\Interfaces\NotificationInterface;
use App\Models\Notification;
use App\Models\User;
use DB;

class NotificationRepository implements NotificationInterface
{
    public function findNotification($id = null)
    {
        if($id) {
            return User::where('id', $id)->get();
        }

        return User::all();
    }

    public function createNotification($data=[],$type=null)
    {
        //Request is valid, create new order

        return $notification= Notification::create([
            'notification_type' => $type,
            'notification_to_user_id' => $data['notification_to_user_id'],
            'notification_body' => $data['notification_body'],
        ]);

    }
}
