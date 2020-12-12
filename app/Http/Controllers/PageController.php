<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartDetail;
use App\Category;
use App\Food;
use Illuminate\Http\Request;

use App\Helpers\UploadFileToS3;
use App\Helpers\Count;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    //
    public function default(){
        $user = Auth::user();
        if($user){
            return redirect('/admin');
        }else{
            return redirect('/admin/login');
        }
    }

    public function index(){
        $url = 'dashboard';
        $count_food = Food::where([])->select('id')->count();
        $count_user = User::where([])->select('id')->count();
        $count_cart = Cart::where([])->select('id')->count();

        //Chart
        $now = Carbon::now()->format('Y-m-d');
        $count_cart = Cart::where('status',1)->where('updated_at','like',$now.'%')->count();
        $count_cart_not = Cart::where('status',0)->where('updated_at','like',$now.'%')->count();
        $value_carts = Cart::where('status',1)->where('updated_at','like',$now.'%')->select(
            DB::raw("SUM(total) as value"),
            DB::raw("DATE_FORMAT(updated_at, '%H %p') as hour")
        )->groupBy('hour')->get();
        $last_total_array = "";
        $datas_total = [];
        $today_total = 0;
        for($i = 0; $i < 24; $i++){
            $total = 0;
            $hour = Carbon::now()->endOfDay()->subHours($i)->format('H A');
            foreach($value_carts as $cart){
                if($cart->hour == $hour){
                    $total += $cart->value;
                    $today_total += $cart->value;
                }
            }
            $datas_total[] = $total;
        }

        $datas_total_array = array_reverse($datas_total);
        $last_total_array = "".$datas_total_array[0].",".$datas_total_array[1].",".$datas_total_array[2].",".$datas_total_array[3].",".$datas_total_array[4].",".$datas_total_array[5].",".$datas_total_array[6].",".$datas_total_array[7].","
        .$datas_total_array[8].",".$datas_total_array[9].",".$datas_total_array[10].",".$datas_total_array[11].",".$datas_total_array[12].",".$datas_total_array[13].",".$datas_total_array[14].",".$datas_total_array[15].","
        .$datas_total_array[16].",".$datas_total_array[17].",".$datas_total_array[18].",".$datas_total_array[19].",".$datas_total_array[20].",".$datas_total_array[21].",".$datas_total_array[22].",".$datas_total_array[23]."";
        $labels = '00 AM,01 AM,02 AM,03 AM,04 AM,05 AM,06 AM,07 AM,08 AM,09 AM,10 AM,11 AM,12 PM,13 PM,14 PM,15 PM,16 PM,17 PM,18 PM,19 PM,20 PM,21 PM,23 PM,23 PM';

        return view('admin.index')->with([
            'url' => $url,
            'count_food' => $count_food,
            'count_user' => $count_user,
            'count_cart' => $count_cart,
            'labels' => $labels,
            'datas' => $last_total_array,
            'today' => $now,
            'total' => $today_total,
            'count_cart' => $count_cart,
            'count_cart_not' => $count_cart_not,
        ]);
    }

    public function login(){
        return view('admin.auth.login');
    }

    public function register(){
        return view('admin.auth.register');
    }

    //Analyst

    public function analystRevenue(Request $request){
        $url = 'analyst-revenue';
        //Revenue chart
        $month = Carbon::now()->format("m");
        $year = Carbon::now()->format("Y");
        $total = 0;
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            $count_day_of_month = 31;
        }elseif($month == 2){
            if($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)){
                $count_day_of_month = 29;
            }else{
                $count_day_of_month = 28;
            }
        }else{
            $count_day_of_month = 30;                       
        }
        $time = $year.'-'.$month;
        $value_carts = Cart::where('status',1)->where('order_time','like',$time.'%')->select(
            DB::raw("SUM(total) as value"),
            DB::raw("DATE_FORMAT(order_time, '%d') as days")
        )->groupBy('days')->get();

        for($i = 0; $i < $count_day_of_month; $i++) {
            $date = Carbon::now()->endOfMonth()->subDays($i)->format('d');
            $total_for_chart = 0;
            foreach($value_carts as $paid) {
                if ($paid->days == $date) {
                    $total_for_chart += $paid->value;
                }
            }
            $total += $total_for_chart;
            $datas_total[] = $total_for_chart;
            $datas_label[] = $date;
        }
        $datas_total_array = array_reverse($datas_total);
        $labels = "";
        if($count_day_of_month == 31){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31';
            $last_total_array = "".$datas_total_array[0].",".$datas_total_array[1].",".$datas_total_array[2].",".$datas_total_array[3].",".$datas_total_array[4].",".$datas_total_array[5].",".$datas_total_array[6].",".$datas_total_array[7].","
            .$datas_total_array[8].",".$datas_total_array[9].",".$datas_total_array[10].",".$datas_total_array[11].",".$datas_total_array[12].",".$datas_total_array[13].",".$datas_total_array[14].",".$datas_total_array[15].","
            .$datas_total_array[16].",".$datas_total_array[17].",".$datas_total_array[18].",".$datas_total_array[19].",".$datas_total_array[20].",".$datas_total_array[21].",".$datas_total_array[22].",".$datas_total_array[23].","
            .$datas_total_array[24].",".$datas_total_array[25].",".$datas_total_array[26].",".$datas_total_array[27].",".$datas_total_array[28].",".$datas_total_array[29].",".$datas_total_array[30]."";
        }elseif($count_day_of_month == 30){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
            $last_total_array = "".$datas_total_array[0].",".$datas_total_array[1].",".$datas_total_array[2].",".$datas_total_array[3].",".$datas_total_array[4].",".$datas_total_array[5].",".$datas_total_array[6].",".$datas_total_array[7].","
            .$datas_total_array[8].",".$datas_total_array[9].",".$datas_total_array[10].",".$datas_total_array[11].",".$datas_total_array[12].",".$datas_total_array[13].",".$datas_total_array[14].",".$datas_total_array[15].","
            .$datas_total_array[16].",".$datas_total_array[17].",".$datas_total_array[18].",".$datas_total_array[19].",".$datas_total_array[20].",".$datas_total_array[21].",".$datas_total_array[22].",".$datas_total_array[23].","
            .$datas_total_array[24].",".$datas_total_array[25].",".$datas_total_array[26].",".$datas_total_array[27].",".$datas_total_array[28].",".$datas_total_array[29]."";
        }elseif($count_day_of_month == 29){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29';
            $last_total_array = "".$datas_total_array[0].",".$datas_total_array[1].",".$datas_total_array[2].",".$datas_total_array[3].",".$datas_total_array[4].",".$datas_total_array[5].",".$datas_total_array[6].",".$datas_total_array[7].","
            .$datas_total_array[8].",".$datas_total_array[9].",".$datas_total_array[10].",".$datas_total_array[11].",".$datas_total_array[12].",".$datas_total_array[13].",".$datas_total_array[14].",".$datas_total_array[15].","
            .$datas_total_array[16].",".$datas_total_array[17].",".$datas_total_array[18].",".$datas_total_array[19].",".$datas_total_array[20].",".$datas_total_array[21].",".$datas_total_array[22].",".$datas_total_array[23].","
            .$datas_total_array[24].",".$datas_total_array[25].",".$datas_total_array[26].",".$datas_total_array[27].",".$datas_total_array[28]."";
        }elseif($count_day_of_month == 28){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28';
            $last_total_array = "".$datas_total_array[0].",".$datas_total_array[1].",".$datas_total_array[2].",".$datas_total_array[3].",".$datas_total_array[4].",".$datas_total_array[5].",".$datas_total_array[6].",".$datas_total_array[7].","
            .$datas_total_array[8].",".$datas_total_array[9].",".$datas_total_array[10].",".$datas_total_array[11].",".$datas_total_array[12].",".$datas_total_array[13].",".$datas_total_array[14].",".$datas_total_array[15].","
            .$datas_total_array[16].",".$datas_total_array[17].",".$datas_total_array[18].",".$datas_total_array[19].",".$datas_total_array[20].",".$datas_total_array[21].",".$datas_total_array[22].",".$datas_total_array[23].","
            .$datas_total_array[24].",".$datas_total_array[25].",".$datas_total_array[26].",".$datas_total_array[27]."";
        }
       
        //Donut chart by category
        $carts_detail = CartDetail::where([])->select(
            DB::raw("categories.name as name"),
            DB::raw("SUM(cart_details.price * cart_details.quantity) as value")
        )->join('foods', 'cart_details.food_id', '=', 'foods.id'
        )->join('categories', 'foods.cateID','=','categories.id') 
        ->groupBy('categories.name')->get();

        $labels_donut = "";
        $datas_donut = "";
        for($i = 0; $i < count($carts_detail); $i++){
            if($i == 0){
                $labels_donut = $carts_detail[$i]->name.",";
                $datas_donut = $carts_detail[$i]->value.",";
            }elseif($i == (count($carts_detail) - 1)){
                $labels_donut = $labels_donut.$carts_detail[$i]->name."";
                $datas_donut = $datas_donut.$carts_detail[$i]->value."";
                
            }else{
                $labels_donut = $labels_donut.$carts_detail[$i]->name.",";
                $datas_donut = $datas_donut.$carts_detail[$i]->value.",";
            }
        }

        //Donut chart by food
        $foods = Food::where([])->select('id','name')->get();
        $labels_donut_food = "";
        $datas_donut_food = "";
        $carts_detail_food = CartDetail::where([])->select(
            DB::raw("foods.name as name"),  
            DB::raw("SUM(cart_details.price * cart_details.quantity) as value")
        )->join('foods', 'cart_details.food_id', '=', 'foods.id'
        )->groupBy('foods.name')->get();
        for($i = 0; $i < count($foods); $i++){
            $name = $foods[$i]->name;
            $foods[$i]['value'] = 0;
            foreach($carts_detail_food as $cart){
                if($cart->name == $name){
                    $foods[$i]['value'] = $cart->value;
                }
            }
        }
        $labels_donut_food = "";
        $datas_donut_food = "";
        for($i=0;$i<count($foods);$i++){
            if($i == 0){
                $labels_donut_food = $foods[$i]->name.",";
                $datas_donut_food = $foods[$i]->value.",";
            }elseif($i == (count($foods) - 1)){
                $labels_donut_food = $labels_donut_food.$foods[$i]->name."";
                $datas_donut_food = $datas_donut_food.$foods[$i]->value."";
                
            }else{
                $labels_donut_food = $labels_donut_food.$foods[$i]->name.",";
                $datas_donut_food = $datas_donut_food.$foods[$i]->value.",";
            }
        }
        
        return view('admin.analyst.revenue')->with([
            'url' => $url,
            'datas' => $last_total_array,
            'labels' => $labels,
            'total' => $total,
            'labels_donut' => $labels_donut,
            'datas_donut' => $datas_donut,
            'labels_donut_food' => $labels_donut_food,
            'datas_donut_food' => $datas_donut_food,
        ]);
    }

    public function analystCart(){
        $url = 'analyst-cart';
        //Count cart chart
        $month = Carbon::now()->format("m");
        $year = Carbon::now()->format("Y");
        $number = 0;
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            $count_day_of_month = 31;
        }elseif($month == 2){
            if($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)){
                $count_day_of_month = 29;
            }else{
                $count_day_of_month = 28;
            }
        }else{
            $count_day_of_month = 30;                       
        }
        $time = $year.'-'.$month;
        $number_carts = Cart::where('status',1)->where('order_time','like',$time.'%')->select(
            DB::raw("Count(id) as number"),
            DB::raw("DATE_FORMAT(order_time, '%d') as days")
        )->groupBy('days')->get();

        for($i = 0; $i < $count_day_of_month; $i++) {
            $date = Carbon::now()->endOfMonth()->subDays($i)->format('d');
            $number_for_chart = 0;
            foreach($number_carts as $paid) {
                if ($paid->days == $date) {
                    $number_for_chart += $paid->number;
                }
            }
            $number += $number_for_chart;
            $datas_number[] = $number_for_chart;
            $datas_label[] = $date;
        }
        $datas_number_array = array_reverse($datas_number);
        $labels = "";
        if($count_day_of_month == 31){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31';
            $last_number_array = "".$datas_number_array[0].",".$datas_number_array[1].",".$datas_number_array[2].",".$datas_number_array[3].",".$datas_number_array[4].",".$datas_number_array[5].",".$datas_number_array[6].",".$datas_number_array[7].","
            .$datas_number_array[8].",".$datas_number_array[9].",".$datas_number_array[10].",".$datas_number_array[11].",".$datas_number_array[12].",".$datas_number_array[13].",".$datas_number_array[14].",".$datas_number_array[15].","
            .$datas_number_array[16].",".$datas_number_array[17].",".$datas_number_array[18].",".$datas_number_array[19].",".$datas_number_array[20].",".$datas_number_array[21].",".$datas_number_array[22].",".$datas_number_array[23].","
            .$datas_number_array[24].",".$datas_number_array[25].",".$datas_number_array[26].",".$datas_number_array[27].",".$datas_number_array[28].",".$datas_number_array[29].",".$datas_number_array[30]."";
        }elseif($count_day_of_month == 30){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
            $last_number_array = "".$datas_number_array[0].",".$datas_number_array[1].",".$datas_number_array[2].",".$datas_number_array[3].",".$datas_number_array[4].",".$datas_number_array[5].",".$datas_number_array[6].",".$datas_number_array[7].","
            .$datas_number_array[8].",".$datas_number_array[9].",".$datas_number_array[10].",".$datas_number_array[11].",".$datas_number_array[12].",".$datas_number_array[13].",".$datas_number_array[14].",".$datas_number_array[15].","
            .$datas_number_array[16].",".$datas_number_array[17].",".$datas_number_array[18].",".$datas_number_array[19].",".$datas_number_array[20].",".$datas_number_array[21].",".$datas_number_array[22].",".$datas_number_array[23].","
            .$datas_number_array[24].",".$datas_number_array[25].",".$datas_number_array[26].",".$datas_number_array[27].",".$datas_number_array[28].",".$datas_number_array[29]."";
        }elseif($count_day_of_month == 29){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29';
            $last_number_array = "".$datas_number_array[0].",".$datas_number_array[1].",".$datas_number_array[2].",".$datas_number_array[3].",".$datas_number_array[4].",".$datas_number_array[5].",".$datas_number_array[6].",".$datas_number_array[7].","
            .$datas_number_array[8].",".$datas_number_array[9].",".$datas_number_array[10].",".$datas_number_array[11].",".$datas_number_array[12].",".$datas_number_array[13].",".$datas_number_array[14].",".$datas_number_array[15].","
            .$datas_number_array[16].",".$datas_number_array[17].",".$datas_number_array[18].",".$datas_number_array[19].",".$datas_number_array[20].",".$datas_number_array[21].",".$datas_number_array[22].",".$datas_number_array[23].","
            .$datas_number_array[24].",".$datas_number_array[25].",".$datas_number_array[26].",".$datas_number_array[27].",".$datas_number_array[28]."";
        }elseif($count_day_of_month == 28){
            $labels = '01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28';
            $last_number_array = "".$datas_number_array[0].",".$datas_number_array[1].",".$datas_number_array[2].",".$datas_number_array[3].",".$datas_number_array[4].",".$datas_number_array[5].",".$datas_number_array[6].",".$datas_number_array[7].","
            .$datas_number_array[8].",".$datas_number_array[9].",".$datas_number_array[10].",".$datas_number_array[11].",".$datas_number_array[12].",".$datas_number_array[13].",".$datas_number_array[14].",".$datas_number_array[15].","
            .$datas_number_array[16].",".$datas_number_array[17].",".$datas_number_array[18].",".$datas_number_array[19].",".$datas_number_array[20].",".$datas_number_array[21].",".$datas_number_array[22].",".$datas_number_array[23].","
            .$datas_number_array[24].",".$datas_number_array[25].",".$datas_number_array[26].",".$datas_number_array[27]."";
        }
        //Donut chart by category
        $carts_detail = CartDetail::where([])->select(
            DB::raw("categories.name as name"),
            DB::raw("Count(cart_details.id) as number")
        )->join('foods', 'cart_details.food_id', '=', 'foods.id'
        )->join('categories', 'foods.cateID','=','categories.id') 
        ->groupBy('categories.name')->get();

        $labels_donut = "";
        $datas_donut = "";
        for($i = 0; $i < count($carts_detail); $i++){
            if($i == 0){
                $labels_donut = $carts_detail[$i]->name.",";
                $datas_donut = $carts_detail[$i]->number.",";
            }elseif($i == (count($carts_detail) - 1)){
                $labels_donut = $labels_donut.$carts_detail[$i]->name."";
                $datas_donut = $datas_donut.$carts_detail[$i]->number."";
                
            }else{
                $labels_donut = $labels_donut.$carts_detail[$i]->name.",";
                $datas_donut = $datas_donut.$carts_detail[$i]->number.",";
            }
        }

        //Donut chart by food
        $foods = Food::where([])->select('id','name')->get();
        $labels_donut_food = "";
        $datas_donut_food = "";
        $carts_detail_food = CartDetail::where([])->select(
            DB::raw("foods.name as name"),  
            DB::raw("Count(cart_details.id) as number")
        )->join('foods', 'cart_details.food_id', '=', 'foods.id'
        )->groupBy('foods.name')->get();
        for($i = 0; $i < count($foods); $i++){
            $name = $foods[$i]->name;
            $foods[$i]['count'] = 0;
            foreach($carts_detail_food as $cart){
                if($cart->name == $name){
                    $foods[$i]['count'] = $cart->number;
                }
            }
        }
        $labels_donut_food = "";
        $datas_donut_food = "";
        for($i=0;$i<count($foods);$i++){
            if($i == 0){
                $labels_donut_food = $foods[$i]->name.",";
                $datas_donut_food = $foods[$i]->count.",";
            }elseif($i == (count($foods) - 1)){
                $labels_donut_food = $labels_donut_food.$foods[$i]->name."";
                $datas_donut_food = $datas_donut_food.$foods[$i]->count."";
                
            }else{
                $labels_donut_food = $labels_donut_food.$foods[$i]->name.",";
                $datas_donut_food = $datas_donut_food.$foods[$i]->count.",";
            }
        }
     
        return view('admin.analyst.cart')->with([
            'url' => $url,
            'labels' => $labels,
            'datas' => $last_number_array,
            'labels_donut' => $labels_donut,
            'datas_donut' => $datas_donut,
            'labels_donut_food' => $labels_donut_food,
            'datas_donut_food' => $datas_donut_food,
        ]);
    }

    public function analystFood(Request $request){
        $url = 'analyst-food';
        $foods = Food::where([])->get();
        foreach($foods as $food){
            $food['count_cart'] = CartDetail::where('food_id',$food->id)->count();
            $sold_time = CartDetail::where('food_id',$food->id)->sum('quantity');
            if($sold_time > 0){
                $food['sold_time'] = CartDetail::where('food_id',$food->id)->sum('quantity');
                $total = $sold_time * $food->price;
                $food['sold_total'] = $total;
            }else{
                $food['sold_time'] = 0;
                $food['sold_total'] = 0;
            }

            $count_rate = Rating::where('food_id',$food->id)->count();
            $sum_rate = Rating::Where('food_id',$food->id)->sum('rate_value');
            if($count_rate > 0){
                $food['rate'] = ceil($sum_rate/$count_rate);
            }else{
                $food['rate'] = 'Non';
            }
        }
        return view('admin.analyst.food')->with([
            'url' => $url,
            'foods' => $foods,
        ]);
    }

    //User 
    public function pageUsers(){
        $url = 'users';
        $users = User::where([])->orderBy('created_at','DESC')->get();
        foreach($users as $user){
            $user['count_cart'] = Count::countCartOfUser($user->id);
            $user['total_bill'] = Count::TotalCartValueOfUser($user->id);
        }
        return view('admin.user.users')->with([
            'url' => $url,
            'users' => $users,
        ]);
    }

    public function pageAddUser(Request $request){
        $url = $request->path();
        return view('admin.user.add')->with([
            'url' => $url,
        ]);
    }

    public function pageEditUser($id){
        $url = 'edit-user';
        $user = User::find($id);
        if($user){
            return view('admin.user.edit')->with([
                'url' => $url,
                'user' => $user,
            ]);
        }else{
            return redirect()->with([
                'warning' => 'Không tìm thấy người dùng này.'
            ]);
        }
    }

    //Category
    public function pageCategories(){
        $url = 'categories';
        $categories = Category::all();
        if($categories){
            foreach($categories as $category){
                $category['count_food'] = Count::countFoodOfCategory($category->id);
            }
            return view('admin.category.categories')->with([
                'url' => $url,
                'categories' => $categories,
            ]);
        }else{
            return;
        }
    }

    public function pageAddCategory(){
        $url = 'create-category';
        return view('admin.category.add')->with([
            'url' => $url,
        ]);
    }

    //Food

    public function pageFoods(){
        $url = 'foods';
        $foods = Food::all();
        $categories = Category::all();
        foreach($foods as $food){
            $category = Category::find($food->cateID);
            if($category){
                $food['category_name'] = $category->name;
            }else{
                $food['category_name'] = null;
            }
        }
        return view('admin.food.foods')->with([
            'url' => $url,
            'foods' => $foods,
            'categories' => $categories,
        ]);
    }

    public function pageAddFood(){
       $url = 'create-food';
       $categories = Category::all();
       return view('admin.food.add')->with([
           'url' => $url,
           'categories' => $categories,
       ]);
    }

    public function pageEditFood($id){
        $url = 'edit-food';
        $categories = Category::all();
        $food = Food::find($id);
        if($food){
            $count_rate = Rating::where('food_id',$food->id)->count();
            $sum_rate = Rating::Where('food_id',$food->id)->sum('rate_value');
            if($count_rate > 0){
                $food['rate'] = ceil($sum_rate/$count_rate);
            }else{
                $food['rate'] = 'Non';
            }
            $rates = Rating::where('food_id',$food->id)->orderBy('id','DESC')->get();
            return view('admin.food.edit')->with([
                'url' => $url,
                'categories' => $categories,
                'food' => $food,
                'rates' => $rates,
            ]);
        }else{
            return redirect('/admin/foods')->with([
                'warning' => 'Không tìm thấy món ăn này.',
            ]);
        }
    }

    //Cart
    public function pageCarts($type){
        $url = 'carts';
        switch($type){
            case 'all':
                $carts = Cart::where([])->orderBy('created_at')->get();
            break;
            case 'paid':
                $carts = Cart::where('status',1)->orderBy('created_at')->get();
            break;
            case 'new':
                $carts = Cart::where('status',0)->orderBy('created_at')->get();
            break;
            default;
        }
        foreach($carts as $cart){
            $details = CartDetail::where([
                'cart_id' => $cart->order_id,
            ])->get();

            foreach ($details as $detail) {
                $food = Food::find($detail->food_id);
                $detail['food_name'] = $food->name;
            }
            $customer = User::find($cart->user_id);
            $cart['customer_name'] = $customer->name;
            $cart['customer_phone_number'] = $customer->phone_number;
            $cart['customer_id'] = $customer->id;
            $cart['customer_id'] = $customer->id;
            $cart['details'] = $details;
        }
        return view('admin.cart.carts')->with([
            'url' => $url,
            'type' => $type,
            'carts' => $carts,
        ]);
    }

    public function editCategory($id){
        $url = 'edit-category';
        $category = Category::find($id);
        if($category){
            return view('admin.category.edit')->with([
                'url' => $url,
                'category' => $category,
            ]);
        }else{
            return redirect('/admin/categories')->with([
                'danger' => 'Category not found',
            ]);
        }
    }
}
