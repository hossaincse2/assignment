<?php

namespace App\Helper;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class HelperClass
{
   public static function totalNotification(){
      return Notification::where('notification_to_user_id' ,Auth::id())->where('status','N')->count();
   }
}
