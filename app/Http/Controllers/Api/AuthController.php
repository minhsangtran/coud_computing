<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Http\Controllers\Controller;
use Validator;

class AuthController extends Controller
{
    public function signup(Request $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->ava_src = 'https://s3.ap-southeast-1.amazonaws.com/yamlive/89__1574071096.png';
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Successfully created user!',
        ], 201);
    }

    // public function login(Request $request) {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //         'remember_me' => 'boolean'
    //     ]);
    //     $credentials = $request->only('email', 'password');
    //     if(!Auth::attempt($credentials)) {
    //         return response()->json([
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }
    //     $user = $request->user();
    //     $tokenResult = $user->createToken('Personal Access Token');
    //     $token = $tokenResult->token;
    //     if ($request->remember_me)
    //         $token->expires_at = Carbon::now()->addWeeks(1);
    //     $token->save();
    //     return response()->json([
    //         'access_token' => $tokenResult->accessToken,
    //         'token_type' => 'Bearer',
    //         'expires_at' => Carbon::parse(
    //             $tokenResult->token->expires_at
    //         )->toDateTimeString()
    //     ]);
    // }

    // public function logout(Request $request) {
    //     $request->user()->token()->revoke();
    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }

    // public function user(Request $request) {
    //     return response()->json($request->user());
    // }
    // //create otp
    // public function generateOTP(){
    //     $otp = mt_rand(100000,999999);
    //     return $otp;
    // }
    // //send email and reset password
    // public function sendEmail(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $user = User::where('email',$request->email)->first();
    //     if($user){
    //         $now = Carbon::now();
    //         $user->otp = $this->generateOTP();
    //         $user->expired_otp = $now;
    //         $user->save();

    //         Mail::to($user->email)
    //             ->send(new ForgetPassword($user));
    //         return response()->json([
    //             'message' => 'mail have been sent',
    //         ],200);

    //     }else{
    //         return response()->json([
    //             'message' => 'unauthorized',
    //         ], 404);
    //     }
    // }
    // public function confirmOTP(Request $request){
    //     $now = Carbon::now();
    //     $user = User::where('email',$request->email)->first();

    //     if($user){
    //         if($user->otp == $request->otp){
    //             $otp_created = $user->expired_otp;
    //             $otp_created_carbon = Carbon::parse(($otp_created));
    //             if( $otp_created_carbon->addMinutes(10)->greaterThan($now)){
    //                 return response()->json([
    //                     'message' => 'Confirm OTP success',
    //                     'user_id' => $user->id, 
    //                 ],200);
    //             }else{
    //                 return response()->json([
    //                     'message' => 'Expried time confirm'
    //                 ],404);
    //             }
    //         }else{
    //             return response()->json([
    //                 'message' => 'invalid otp'
    //             ],401);
    //         }
    //     }else{
    //         return response()->json([
    //             'message' => 'unauthorized',
    //         ],404);
    //     }
    // }
    //  public function postResetPassword(Request $request){
    //     $user = User::find($request->user_id);
    //     if($user){
    //         $user->password = bcrypt($request->password);
    //         $user->save();
    //         return response()->json([
    //             'message' => 'Edit password success'
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'message' => 'unauthorized',
    //         ],404);
    //     }
    // }

}
