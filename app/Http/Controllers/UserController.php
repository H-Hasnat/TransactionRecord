<?php

namespace App\Http\Controllers;

use APP\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


function Login_page(){
    return view('auth.login');
}

function signup_page(){
    return view('auth.registration');
}


    function createAccount(Request $request){
       return  User::create([

                'email'=>$request->input('email'),
                'password'=>$request->input('password'),

        ]);


    }

    // function userLogin(Request $request){

    //     $number=$request->input('number');
    //     $password=$request->input('password');

    //    $count=User::where('number','=',$number)->where('password','=',$password)->select('id')->first();


    // if($count!=null){
    //     $token=JWTToken::createToken($number,$count->id);

    //     return response()->json([
    //         'status'=>'success',
    //         'token'=>$token,
    //         'messsage'=>'Login Successfully',

    //     ],200)->cookie('token',$token,time()+60*24*30);
    // }else{
    //     return response()->json([
    //         'status'=>'failed',
    //     ]);
    // }

    // }



    // public function userLogin(Request $request)
    // {
    //     $number = $request->input('number');
    //     $password = $request->input('password');

    //     $count = User::where('number', '=', $number)
    //                  ->where('password', '=', $password)
    //                  ->select('id')
    //                  ->first();

    //     if ($count != null) {
    //         $token = JWTToken::createToken($number, $count->id);

    //         // ডাইনামিক কুকি নাম ব্যবহারকারী ID সহ
    //         return response()->json([
    //             'status' => 'success',
    //             'token' => $token,
    //             'message' => 'Login Successfully',
    //         ], 200)->cookie("user_token_{$count->id}", $token, time() + 60 * 24 * 30);
    //     } else {
    //         return response()->json([
    //             'status' => 'failed',
    //         ]);
    //     }
    // }



    function userLogin(Request $request){

        $email=$request->input('number');
        $password=$request->input('password');

       $count=User::where('number','=',$email)->where('password','=',$password)->select('id')->first();


    if($count!=null){
        $token=JWTToken::createToken($email,$count->id);

        return response()->json([
            'status'=>'success',
            'token'=>$token,
            'messsage'=>'Login Successfully',

        ],200)->cookie('token',$token,time()+60*24*30);
    }else{
        return response()->json([
            'status'=>'failed',
        ]);
    }

    }

    function Dashboard(Request $request){
      $id=$request->header('id');

      $user=User::find($id);
      if ($user->isAdmin()) {
        return view('admin-dashboard');
    }else if($user->isCustomer()){
        return view('cus-dashboard');

    }else{
        return view('login');
    }



    }


    function UserProfile(Request $request){
        $id=$request->header('id');
      return  User::where('id',$id)->get();
    }

    function UpdateProfile(Request $request){
        $id=$request->header('id');
        $name=$request->input('name');
        $password=$request->input('password');

        $role=$request->input('role');
        $phn_nmbr=$request->input('phn_nmbr');
        $address=$request->input('address');

        return User::where('id',$id)->update([
            'name'=>$name,

            'password'=>$password,
            'role'=>$role,
            'Phone Number'=>$phn_nmbr,
            'address'=>$address
        ]);
    }



    function CusProfile(Request $request){
        $id=$request->header('id');

      return  User::where('id',$id)->where('role','customer')->get();
    }

    // function CusProfile(Request $request){
    //     $id=$request->header('id');
    //     $name=$request->input('name');
    //     $password=$request->input('password');

    //     $role=$request->input('role');
    //     $phn_nmbr=$request->input('phn_nmbr');
    //     $address=$request->input('address');

    //     return User::where('id',$id)->update([
    //         'name'=>$name,

    //         'password'=>$password,
    //         'role'=>$role,
    //         'Phone Number'=>$phn_nmbr,
    //         'address'=>$address
    //     ]);
    // }

}
