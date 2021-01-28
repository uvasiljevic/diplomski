<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function registration(Request $request){

        $rules = [
            "r_firstname"    => "required|regex:/^[\pL\s\-]+$/u",
            "r_lastname"     => "required|regex:/^[\pL\s\-]+$/u",
            'r_email'        => 'required|unique:uv_user,email|email',
            "r_phone"        => "required|alpha_dash",
            "r_city"         => "required|regex:/^[\pL\s\-]+$/u",
            "r_zip"          => "required|numeric",
            "r_street"       => "required|regex:/^[\pL\s\-]+$/u",
            "r_streetNumber" => "required|numeric",
            "r_password"     => "required|min:6|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonError($validator->messages(), 400);
        }

        $user = new User;
        $flag = '';
        try{

            $user->firstName    = $request->r_firstname;
            $user->lastName     = $request->r_lastname;
            $user->email        = $request->r_email;
            $user->phone        = $request->r_phone;
            $user->city         = $request->r_city;
            $user->zipCode      = $request->r_zip;
            $user->street       = $request->r_street;
            $user->streetNumber = $request->r_streetNumber;
            $md5password        = md5($request->r_password_confirmation);
            $user->password     = $md5password;
            $user->dateCreate  = date('Y-m-d H:i:s');

             $user->save();

             return response()->json('Successful registration!', 201);

        }
        catch(\Exception $ex) {
            \Log::error($ex->getMessage());
            return $this->jsonError('Problem with server!', 500);
        }


    }

    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            "password" => "required|min:6"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonError($validator->messages(), 400);
        }

        $md5password = md5($request->password);
        $user = User::where('email', $request->email)->where('password', $md5password)->first();

        if($user){
            $request->session()->put('user', $user);
            return response()->json(200, 200);
        }
        else {
            return $this->jsonError(['message' => 'Wrong email or password!'], 400);
        }

    }

    public function logout(Request $request){
        if($request->session()->has('user')){
            $request->session()->forget('user');
            //$request->session()->flush();

        }

        return redirect("/")->with('message', 'You are logged out.');
    }

}
