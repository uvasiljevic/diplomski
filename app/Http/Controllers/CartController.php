<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Product;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class CartController extends Controller
{

    protected $modelProduct;
    protected $modelCourier;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelCourier = new Courier();
    }

    function addToCart(Request $request)
    {
        $cart = new Object_();
        $return = new Object_();

        if ($request->quantity <= 0) {
            $return->message = 'Quantity has to be more than 0.';
            return response()->json( $return, 400);
        }

        $product     = Product::find($request->productId);

        if (!$product || empty($request->maxQuantity)) {
            $return->message = 'Bad request!';
            return response()->json($return, 400);
        }

        if ($request->session()->has('cart')) {
            $response = $this->updateCart($request, $product);

            if($response) {
                $code = 200;
                if($response->status == 400){
                    $code = 400;
                }
                return response()->json($response, $code);
            }
        }

        $maxQuantity = $this->getMaxQuantityForProduct($product);

        if ($request->quantity > $maxQuantity) {
            $return->message = 'Available '. $maxQuantity .' '. $product->name.' on stock';
            return response()->json($return, 400);
        }

        $cart->productName = $product->name;
        $cart->permalink   = $this->modelProduct->breadCrumbs($product);
        $cart->image       = $product->image;
        $cart->price       = $product->price;
        $cart->quantity    = $request->quantity;
        $cart->maxQuantity = $request->maxQuantity;
        $cart->totalPrice  = number_format((float)$request->quantity*$product->price, '2', '.', '');
        $cart->productId   = $product->id;

        $request->session()->push('cart', $cart);

        $return->message   = 'Successfully added to cart!';
        $return->countCart = $this->countCartItems($request);
        $return->status    = 201;

        return response()->json($return, 201);
    }

    function updateCart($request, $product){
        $return = new Object_();

        foreach ($request->session()->get('cart') as $item) {
            if ($item->productId == $product->id) {

                $flagQuantity = $this->checkQuantityInCart($item, $request);
                if($flagQuantity->status == 400){
                    return $flagQuantity;
                }

                $item->quantity    += $request->quantity;
                $item->totalPrice  = number_format((float)$item->quantity*$product->price, '2', '.', '');

                $return->message   = 'Successfully updated cart!';
                $return->countCart = $this->countCartItems($request);
                $return->status    = 201;

                return $return;
            }
        }
    }

    function updateCartItem(Request $request){
        $return            = array();
        $request->cartItem = true;

        $flag  = false;
        foreach ($request->session()->get('cart') as $item) {
            if ($item->productId == $request->productId) {

                $flagQuantity = $this->checkQuantityInCart($item, $request);
                if($flagQuantity->status == 400){
                    return response()->json($flagQuantity->message,$flagQuantity->status);
                }

                $item->quantity    = $request->quantity;
                $item->totalPrice  = number_format((float)$item->quantity*$item->price, '2', '.', '');
                $flag              = true;
            }
        }

        if(!$flag){
            return response()->json('Error', 400);
        }

        $filter               = $this->filter();

        $courier              = $this->modelCourier->getRecordPublic($this->modelCourier->getTableName(), $filter);

        $totalCartPrice       = $this->getTotalCartPrice($request);

        $courierPrice         = 0;
        if($courier){
            $courierPrice     = $this->modelCourier->countCourierPrice($courier[0], $totalCartPrice);
        }

        $totalForPay  = $totalCartPrice + $courierPrice;

        $return['message']        = 'Successfully updated cart!';
        $return['countCart']      = $this->countCartItems($request);
        $return['status']         = 201;
        $return['cart']           = $request->session()->get('cart');
        $return['totalCartPrice'] = number_format((float)$this->getTotalCartPrice($request), '2', '.', '');
        $return['totalForPay']    = number_format((float)$totalForPay, '2', '.', '');

        return response()->json($return, $return['status']);
    }

    function checkQuantityInCart($cartItem, $request){
        $return = new Object_();

        $product     = Product::find($request->productId);

        if (!$product) {
            $return->message = 'Bad request!';
            return response()->json($return, 400);
        }

        $maxQuantity = $this->getMaxQuantityForProduct($product);

        if(isset($request->cartItem) && $request->cartItem){
            $countIncart       = $request->quantity;
        }else{
            $countIncart       = $cartItem->quantity + $request->quantity;
        }

        if($countIncart > $maxQuantity){
            $return->message   = 'You already have '.$cartItem->quantity.' '.$cartItem->productName.' in your cart. Limit for this product is '.$cartItem->maxQuantity;
            $return->countCart = $this->countCartItems($request);
            $return->status    = 400;

            return $return;
        }

        $return->status = 200;
        return $return;
    }

    public function clearCart(Request $request){

        if($request->session()->has('cart')) {
            $request->session()->forget('cart');
        }
        if($request->session()->has('countCart')) {
            $request->session()->forget('countCart');
        }

        return response()->json('Success', 204);
    }

    public function removeCartItem(Request $request){
        $return            = array();
        $request->cartItem = true;

        $flag     = false;
        $products = $request->session()->get('cart');
        foreach ($request->session()->get('cart') as $key => $item) {

            if ($item->productId == $request->productId) {
                unset($products[$key]);
                $request->session()->put('cart', $products);
                $flag  = true;
            }
        }

        if(!$flag){
            return response()->json('Error', 400);
        }

        $filter               = $this->filter();

        $courier              = $this->modelCourier->getRecordPublic($this->modelCourier->getTableName(), $filter);

        $totalCartPrice       = $this->getTotalCartPrice($request);

        $courierPrice         = 0;
        if($courier){
            $courierPrice     = $this->modelCourier->countCourierPrice($courier[0], $totalCartPrice);
        }

        $totalForPay  = $totalCartPrice + $courierPrice;

        $return['message']        = 'Successfully updated cart!';
        $return['countCart']      = $this->countCartItems($request);
        $return['status']         = 200;
        $return['cart']           = $request->session()->has('cart') ? $request->session()->get('cart') : '';
        $return['totalCartPrice'] = number_format((float)$this->getTotalCartPrice($request), '2', '.', '');
        $return['totalForPay']    = number_format((float)$totalForPay, '2', '.', '');

        return response()->json($return, $return['status']);
    }
}
