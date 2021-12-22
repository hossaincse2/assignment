<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','order_id','oder_number','total_amount','total_qty','total_vat','net_amount','created_by'];
 
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function product(){
        return $this->hasMany(Product::class,'order_id','id');
    }
}
