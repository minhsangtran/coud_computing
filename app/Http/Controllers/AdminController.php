<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartDetail;
use App\Category;
use App\Food;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\UploadFileToS3;
use App\Helpers\Count;

class AdminController extends Controller
{
    //
    public function postLogin(Request $request){
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password
        );
        Auth::attempt($userdata);
        if (!Auth::user()) {
            return redirect('/admin/login')->with('errors', 'Sai thông tin đăng nhập');
        }else{
            $user = Auth::user();
            if($user->type == 1){
                return redirect('/admin');
            }else{
                Auth::logout();
                return redirect('/admin/login')->with('errors', 'Sai thông tin đăng nhập');
            }
        }
    }

    public function postAddUser(Request $request){
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->password = $request->password;
        $user->save();

        return redirect('/admin/users')->with([
            'success' => 'Create user success',
        ]);
    }

    public function postEditUser($id, Request $request){
        $user = User::find($id);
        if($user){
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->save();

            return redirect('/admin/users')->with([
                'success' => 'Edit user success',
            ]);
        }else{
            return redirect('/admin/users')->with([
                'danger' => 'Customer not found',
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin/login');
    }

    public function postRegister(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect('/admin/register');
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->type = 1;
        $user->ava_src  = 'https://s3.ap-southeast-1.amazonaws.com/yamlive/14__1573142658.png';
        $user->save();
        $userdata = array(
            'email'     => $request->input('email'),
            'password'  => $request->input('password')
        );
        Auth::attempt($userdata);
        return redirect('/admin/login')->with('message', 'Register success');
    }

    //Category
    public function postAddCategory(Request $request){
        $category = new Category();
        $category->name = $request->category_name;
        if($request->image){
            $category->image = UploadFileToS3::upload($request->image);
        }
        $category->save();
        return redirect('/admin/categories')->with([
            'success' => 'Create category success.',
        ]);
    }
    public function editCategory($id,Request $request){
        $category = Category::find($id);
        if($category){
            $category->name = $request->name;
            if($request->image){
                $category->image = UploadFileToS3::upload($request->image);
            }
            $category->save();
            return redirect('/admin/categories')->with([
                'success' => 'Edit category success.',
            ]);
        }else{
            return redirect('/admin/categories')->with([
                'danger' => 'Category not found',
            ]);
        }
    }
    //Food
    public function postAddFood(Request $request){
        $food = new Food();
        $food->name = $request->food_name;
        $food->description = $request->food_description;
        $food->cateID = $request->food_cateID;
        $food->price = $request->food_price;
        $food->stock = $request->food_stock;
        if($request->food_image){
            $food->image = UploadFileToS3::upload($request->food_image);
        }
        $food->save();
        return redirect('/admin/foods')->with([
            'success' => 'Thêm món ăn thành công.',
        ]);
    }

    public function deleteFood($id){
        $food = Food::find($id);
        if($food){
            $cart_detail = CartDetail::where('food_id',$food->id)->first();
            if($cart_detail){
                return redirect('/admin/foods')->with([
                    'danger' => 'Xóa món ăn thất bại.',
                ]);
            }else{
                $food->delete();
                return redirect('/admin/foods')->with([
                    'success' => 'Xóa món ăn thành công.',
                ]);
            }
        }else{
            return redirect('/admin/foods')->with([
                'warning' => 'Không tìm thấy món ăn này.',
            ]);
        }
    }

    public function deleteCart($id){
        $cart = Cart::find($id);
        if($cart){
            $carts_detail = CartDetail::where('cart_id',$cart->order_id)->get();
            foreach($carts_detail as $cart_detail){
                $cart_detail->delete();
            }
            $cart->delete();
            return redirect('/admin/carts/all')->with([
                'success' => 'Delete cart success',
            ]);
        }else{
            return redirect('/admin/carts/all')->with([
                'danger' => 'Cart not found',
            ]);
        }
    }

    public function postEditFood($id, Request $request){
        $food = Food::find($id);
        if($food){
            $food->name = $request->food_name;
            $food->description = $request->food_description;
            $food->price = $request->food_price;
            $food->stock = $request->food_stock;
            $food->cateID = $request->food_cateID;
            if($request->food_image){
                UploadFileToS3::delete($food->image);
                $food->image = UploadFileToS3::upload($request->food_image);
            }
            $food->save();
            return redirect('/admin/foods')->with([
                'success' => 'Sửa món ăn thành công.',
            ]);
        }else{
            return redirect('/admin/foods')->with([
                'warning' => 'Không tìm thấy món ăn này.',
            ]);
        }
    }

    public function changeStatus($id){
        $cart = Cart::find($id);
        if($cart){
            if($cart->status == 0){

                $carts_detail = CartDetail::where('cart_id',$cart->order_id)->get();
                foreach($carts_detail as $cart_detail){
                    $food = Food::find($cart_detail->food_id);
                    if($food){
                        $food->stock = $food->stock - $cart_detail->quantity;
                        $food->save();
                    }
                }
                $cart->status = 1;
                $cart->save();
                return redirect('/admin/carts/new')->with([
                    'success' => 'Xử lí đơn hàng thành công.',
                ]);
            }elseif($cart->status == 1){
                $cart->status = 0;
                $cart->save();
                return redirect('/admin/carts/new')->with([
                    'success' => 'Phục hồi đơn hàng thành công',
                ]);
            }
        }else{
            return redirect('/admin/carts/all')->with([
                'warning' => 'Không tìm thấy hóa đơn này.'
            ]);
        }
    }

    public function deleteUser($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return redirect('/admin/users')->with([
                'success' => 'Delete user success',
            ]);
        }else{
            return redirect('/admin/users')->with([
                'danger' => 'User not found',
            ]);
        }
    }
}
