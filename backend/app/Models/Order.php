<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_no','user_id','total_amount','total_qty','total_vat','net_amount','contact_no','shipping_address','shipping_method','status','created_by'];

    protected $with = ['user','orderDetails'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

}
