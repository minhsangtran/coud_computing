<?php

namespace App\Http\Controllers;

use App\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //
    public function cartChart($month,$year,$type){
        $user = Auth::user();
        if($user){
            $total = 0;
            $last_total_array = "";
            $labels = "";
            if($type == 'month'){
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
                    DB::raw("Count(id) as value"),
                    DB::raw("DATE_FORMAT(order_time, '%d') as days")
                )->groupBy('days')->get();
    
                for($i = 0; $i < $count_day_of_month; $i++) {
                    $date = Carbon::create()->month($month)->endOfMonth()->subDays($i)->format('d');
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

                print_r($last_total_array);
                return;
            }elseif($type == 'year'){
                $value_carts_month = Cart::where('status',1)->where('order_time','like',$year.'%')->select(
                    DB::raw("Count(id) as value"),
                    DB::raw("DATE_FORMAT(order_time, '%M') as months")
                )->groupBy('months')->get();
                for($i = 0; $i < 12; $i++) {
                    $month = Carbon::now()->endOfYear()->startOfMonth()->subMonths($i)->format('F');
                    $total_for_chart = 0;
                    foreach($value_carts_month as $paid_month) {
                        if ($paid_month->months == $month) {
                            $total_for_chart += $paid_month->value;
                        }
                    }
                    $total += $total_for_chart;
                    $datas_total[] = $total_for_chart;
                    $datas_label[] = $month;
                }
                $datas_total_array = array_reverse($datas_total);
                $labels = "January,February,March,April,May,June,July,August,September,October,November,December";
                for($i = 0; $i < 12; $i++){
                    if($i == 0){
                        $last_total_array = $datas_total_array[$i].",";
                    }elseif($i == (11)){
                        $last_total_array = $last_total_array.$datas_total_array[$i]."";
                        
                    }else{
                        $last_total_array = $last_total_array.$datas_total_array[$i].",";
                    }
                }
            }
            return response()->json([
                'message' => 'success',
                'labels' => $labels,
                'datas' => $last_total_array,
                'total'=> $total,
            ]);
        }else{
            return response()->json([
                'message' => 'unauthorized',
            ]);
        }
    }

    public function revenueChart($month,$year,$type){
        $user = Auth::user();
        if($user){
            $total = 0;
            $last_total_array = "";
            $labels = "";
            if($type == 'month'){
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
                    $date = Carbon::create()->month($month)->endOfMonth()->subDays($i)->format('d');
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
            }elseif($type == 'year'){
                $value_carts_month = Cart::where('status',1)->where('order_time','like',$year.'%')->select(
                    DB::raw("SUM(total) as value"),
                    DB::raw("DATE_FORMAT(order_time, '%M') as months")
                )->groupBy('months')->get();
                for($i = 0; $i < 12; $i++) {
                    $month = Carbon::now()->endOfYear()->startOfMonth()->subMonths($i)->format('F');
                    $total_for_chart = 0;
                    foreach($value_carts_month as $paid_month) {
                        if ($paid_month->months == $month) {
                            $total_for_chart += $paid_month->value;
                        }
                    }
                    $total += $total_for_chart;
                    $datas_total[] = $total_for_chart;
                    $datas_label[] = $month;
                }
                $datas_total_array = array_reverse($datas_total);
                $labels = "January,February,March,April,May,June,July,August,September,October,November,December";
                for($i = 0; $i < 12; $i++){
                    if($i == 0){
                        $last_total_array = $datas_total_array[$i].",";
                    }elseif($i == (11)){
                        $last_total_array = $last_total_array.$datas_total_array[$i]."";
                        
                    }else{
                        $last_total_array = $last_total_array.$datas_total_array[$i].",";
                    }
                }
            }
            return response()->json([
                'message' => 'success',
                'labels' => $labels,
                'datas' => $last_total_array,
                'total'=> $total,
            ]);
        }else{
            return response()->json([
                'message' => 'unauthorized',
            ]);
        }
    }
}
