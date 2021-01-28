<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function filter(){
        $filter = [
            "status" => "= 1",
            "del"    => "= -1",
        ];

        return $filter;
    }

    protected function jsonError($message, $code = 500)
    {
        return response()->json([
            "error" => [
                "code" => $code,
                "message" => $message
            ]], $code);
    }

    function countCartItems($request){
        $countCart = 0;

        if($request->session()->has('cart')){

            $cartItems         = $request->session()->get('cart');

            foreach ($cartItems as $item){
                $countCart += $item->quantity;
            }
            //dd($countCart);
            return $countCart;
        }else{
            return 0;
        }
    }

    function getTotalCartPrice($request){
        $totalCartPrice       = 0;
        if($request->session()->has('cart')) {
            foreach ($request->session()->get('cart') as $item){
                $totalCartPrice += $item->totalPrice;
            }
        }

        return $totalCartPrice;
    }
}
