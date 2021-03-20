<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Menu;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Image;
use App\Models\Category;
use App\Models\Courier;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function index(Request $request){


        $this->data['smallAd']    = $this->modelAds->getRecordsPublic($this->modelAds->getTableName(), array('isLarge' => '= -1'));
        $this->data['largeAd']    = $this->modelAds->getRecordsPublic($this->modelAds->getTableName(), array('isLarge' => '= 1'));
        $this->data['homeSlider'] = $this->modelAds->getRecordsPublic($this->modelSlider->getTableName(), $this->filter());
        $this->data['products']   = $this->modelProduct->getRecordsPublic($this->modelProduct->getTableName(), $this->filter(), 0, 8);
        $this->data['countCart']  = $this->countCartItems($request);

        return view('/uv-public/components/home/home', $this->data);

    }

    public function contact(Request $request){

        $this->data['countCart']  = $this->countCartItems($request);
        return view('/uv-public/components/contact/contact', $this->data);

    }

    public function login(Request $request){

        $this->data['countCart']  = $this->countCartItems($request);
        return view('/uv-public/components/login/login', $this->data);

    }

    public function registration(Request $request){

        $this->data['countCart']  = $this->countCartItems($request);
        return view('/uv-public/components/login/registration', $this->data);

    }

    public function products(Request $request, $category = ''){

        $sort               = 'id.DESC';
        $search             = "";
        $offset             = 0;
        $filter             = $this->filter();
        $filterCategory     = $this->filter();
        $this->data['countCart']  = $this->countCartItems($request);

        if($request->method() == 'GET' && $category != ''){
            $filter['category.permalink']         = "= " .$category;
            $filterCategory['permalink']          = "= " .$category;
        }

        $categoryFlag = $this->modelCategory->getRecordsPublic($this->modelCategory->getTableName(), $filterCategory);

        if(count($categoryFlag) == 0){
            abort(404);
        }

        if($request->has('sort')){
            $sort = $request->input('sort');
        }
        if($request->has('search')){
            $search = $request->input('search');
        }
        if($request->has('offset')){
            $offset = $request->input('offset');
        }

        $data  = $this->modelProduct->getRecordsPublic($this->modelProduct->getTableName(), $filter, $offset,8, $sort, $search);

        if($request->method() == 'GET'){
            $this->data['products'] = $data;
            return view('/uv-public/components/product/products', $this->data);
        }

        return response()->json($data, 200);
    }

    public function product(Request $request, $category, $product){

        $filter        = $this->filter();
        $filterRelated = $this->filter();
        $filterImages  = $this->filter();
        $this->data['countCart']  = $this->countCartItems($request);

        if($category != ''){
            $filter['category.permalink']        = "= " .$category;
            $filterRelated['category.permalink'] = "= " .$category;
            $filterRelated['permalink']          = "!= " .$product;
        }

        if($product != ''){
            $filter['permalink'] = "= " .$product;
        }

        $product          = $this->modelProduct->getRecordPublic($this->modelProduct->getTableName(), $filter);
        $relatedProducts  = $this->modelProduct->getRecordsPublic($this->modelProduct->getTableName(), $filterRelated, 0, 4);

        if(!isset($product[0])){
            abort(404);
        }

        if($product){
            $filterImages['productId'] = "= " .$product[0]->id;
        }
        $images           = $this->modelImage->getRecordsPublic($this->modelImage->getTableName(), $filterImages, 0, 3);

        $this->data['maxQuantity']     = $product[0]->quantity - 2;
        $this->data['product']         = $product;
        $this->data['relatedProducts'] = $relatedProducts;
        $this->data['images']          = $images;

        return view('/uv-public/components/product/product', $this->data);


    }

    public function cart(Request $request){

        $filter               = $this->filter();

        $courier              = $this->modelCourier->getRecordPublic($this->modelCourier->getTableName(), $filter);
        $paymentType          = $this->modelPaymentType->getRecordsPublic($this->modelPaymentType->getTableName(), $filter);


        $totalCartPrice       = $this->getTotalCartPrice($request);

        $courierPrice         = 0;
        if($courier){
            $courierPrice     = $this->modelCourier->countCourierPrice($courier[0], $totalCartPrice);
        }

        $totalForPay  = $totalCartPrice + $courierPrice;

        $this->data['couriers']        = $courier;
        $this->data['paymentTypes']    = $paymentType;
        $this->data['countCart']       = $this->countCartItems($request);
        $this->data['totalCartPrice']  = number_format((float)$totalCartPrice, '2', '.', '');
        $this->data['courierPrice']    = number_format((float)$courierPrice, '2', '.', '');
        $this->data['totalForPay']     = number_format((float)$totalForPay, '2', '.', '');
        return view('/uv-public/components/cart/cart', $this->data);

    }

}
