<?php

namespace App\Http\Controllers;

use App\Mail\SendMailConfirmOrder;
use App\Models\Courier;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\PaymentType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    protected $modelOrder;
    protected $modelOrderAddress;
    protected $modelOrderItem ;
    protected $modelCourier;
    protected $modelPaymentType;
    protected $modelProduct;

    public function __construct(){

        $this->modelOrder         = new Order();
        $this->modelOrderAddress  = new OrderAddress();
        $this->modelOrderItem     = new OrderItem();
        $this->modelCourier       = new Courier();
        $this->modelPaymentType   = new PaymentType();
        $this->modelProduct       = new Product();

    }

    public function makeOrder(Request $request){

        $rules = [
            "firstname"    => "required|regex:/^[\pL\s\-]+$/u",
            "lastname"     => "required|regex:/^[\pL\s\-]+$/u",
            'email'        => 'required|email|email',
            "phone"        => "required|alpha_dash",
            "city"         => "required|regex:/^[\pL\s\-]+$/u",
            "zip"          => "required|numeric",
            "street"       => "required|regex:/^[\pL\s\-]+$/u",
            "streetNumber" => "required|numeric",
            "courrier"     => "required|numeric",
            "paymentType"  => "required|alpha",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->jsonError($validator->messages(), 400);
        }

        if(!$request->session()->has('cart')){
            return $this->jsonError('There is no products in cart', 400);
        }

        $userId = -1;
        if($request->session()->has('user')){
            $userId =  $request->session()->get('user')->id;
        }

        $order         = new Order;
        $orderAddress  = new OrderAddress;

        foreach ($request->session()->get('cart') as $item){
            $product      = Product::find($item->productId);
            $maxQuantity  = $this->getMaxQuantityForProduct($product);
            if($item->quantity > $maxQuantity){
                $error = array('Can not order '.$item->quantity.' '.$product->name.'. There is '.$maxQuantity.' '.$product->name.' in stock.');
                return $this->jsonError($error, 400);
            }
        }

        try{
            $order->userId              = $userId;
            $order->carrierId           = $request->courrier;
            $order->firstName           = $request->firstname;
            $order->lastName            = $request->lastname;
            $order->price               = $this->getTotalCartPrice($request);
            $order->paymentType         = $request->paymentType;
            $order->userCreate          = $userId;

            $orderAddress->firstName       = $request->firstname;
            $orderAddress->lastName        = $request->lastname;
            $orderAddress->email           = $request->email;
            $orderAddress->phone           = $request->phone;
            $orderAddress->city            = $request->city;
            $orderAddress->zipCode         = $request->zip;
            $orderAddress->street          = $request->street;
            $orderAddress->streetNumber    = $request->streetNumber;

            DB::transaction(function ()  use ($request, $order, $orderAddress, $userId) {
                $order->save();

                $orderAddress->orderId     = $order->id;

                $orderAddress->save();

                foreach ($request->session()->get('cart') as $item){
                    $orderItem                  = new OrderItem;

                    $orderItem->orderId         = $order->id;
                    $orderItem->productId       = $item->productId;
                    $orderItem->quantity        = $item->quantity;
                    $orderItem->price           = $item->price;
                    $orderItem->userCreate      = $userId;

                    $orderItem->save();

                    $this->updateProductQuantity($item);

                }

            });

            $data = array(
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'order'     => $order->id,
                'price'     => $order->price
            );

            Mail::to($request->email)->send(new SendMailConfirmOrder($data));
            $request->session()->forget('cart');
            $request->session()->forget('countCart');

            $return['orderId'] = $order->id;

            return response()->json($return, 201);
        }
        catch(\Exception $ex) {
            \Log::error($ex->getMessage());
            return $this->jsonError('Problem with server!', 500);
        }

    }
}
