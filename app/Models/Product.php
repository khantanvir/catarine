<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserDetail;
use App\Models\User;
use App\Models\Order;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    //get user name
    public static function get_user_name($id=NULL){
        if(empty($id)){
            return 'No Name';
        }
        $getName = User::where('id',$id)->first();
        return $getName->name;
    }
    public static function get_order_list_by_admin(){
        $get_order = Order::where('status',0)->get();
        return count($get_order);
    }
}
