<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Category;
use App\Models\Courier;
use App\Models\Image;
use App\Models\Menu;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $modelAds;
    protected $modelSlider;
    protected $modelProduct;
    protected $modelImage;
    protected $modelCategory;
    protected $modelCourier;
    protected $modelPaymentType;
    protected $modelOrder;
    protected $data;

    public function __construct()
    {
        $modelMenu                = new Menu();
        $this->modelAds           = new Ads();
        $this->modelSlider        = new Slider();
        $this->modelProduct       = new Product();
        $this->modelCategory      = new Category();
        $this->modelImage         = new Image();
        $this->modelCourier       = new Courier();
        $this->modelPaymentType   = new PaymentType();
        $this->modelOrder         = new Order();

        $this->data['menu']      = $modelMenu->getMenu();
    }

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

    public function updateProductQuantity($item){
        $product = Product::find($item->productId);

        $product->quantity = $product->quantity - $item->quantity;

        return $product->save();

    }

    function getMaxQuantityForProduct($product){
        $maxQuantity = $product->quantity - 2;

        return $maxQuantity;
    }

    public function statusFilterArray(){
        $filter = [
            1  => "Active",
            -1 => "Deactived"
        ];

        return $filter;
    }

    public function deleteFilterArray(){
        $filter = [
            1  => "Active",
            -1 => "Deleted",
        ];

        return $filter;
    }

    public function yesNoArray(){
        $filter = [
            1  => "Yes",
            -1 => "No",
        ];

        return $filter;
    }
}
