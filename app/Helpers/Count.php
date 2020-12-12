<?php
namespace App\Helpers;

use App\Cart;
use App\CartDetail;
use App\Food;
use Storage;

class Count {
    public static function countFoodOfCategory($id){
        $count = Food::where('cateID',$id)->count();
        return $count;
    }

    public static function countCartOfUser($id){
        $count = Cart::where([
            'user_id' => $id,
            'status' => 1,
        ])->count();
        return $count;
    }

    public static function TotalCartValueOfUser($id){
        $sum = 0;
        $carts = Cart::where([
            'user_id' => $id,
            'status' => 1,
        ])->get();
        foreach($carts as $cart){
            $sum += $cart->total;
        }
        return $sum;
    }
}
?>
