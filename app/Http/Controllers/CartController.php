<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class CartController extends Controller
{

    protected $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new Product();
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

        $maxQuantity = $product->quantity - 2;

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
                $countIncart       = $item->quantity + $request->quantity;
                if($countIncart > $item->maxQuantity){
                    $return->message   = 'You already have '.$item->quantity.' '.$item->productName.' in your cart. Limit for that product is '.$item->maxQuantity;
                    $return->countCart = $this->countCartItems($request);
                    $return->status    = 400;

                    return $return;
                }
                $item->quantity    += $request->quantity;
                $item->totalPrice  = number_format((float)$item->quantity*$product->price, '2', '.', '');

                $return->message   = 'Successfully updated cart!';
                $return->countCart = $this->countCartItems($request);
                $return->status    = 201;

                return $return;
            }else{
                return false;
            }
        }
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
}
