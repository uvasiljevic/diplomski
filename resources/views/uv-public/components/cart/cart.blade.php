@extends('uv-public.layouts.pageslayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/cart.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/cart_responsive.css")}}">
@endsection
@section('content')
    <!-- Cart Info -->

    <div class="cart_info">
        <div class="container">
            @if(session()->has('cart'))
            <div class="row">
                <div class="col">
                    <!-- Column Titles -->
                    <div class="cart_info_columns clearfix">
                        <div class="cart_info_col cart_info_col_product">Product</div>
                        <div class="cart_info_col cart_info_col_price">Price</div>
                        <div class="cart_info_col cart_info_col_quantity">Quantity</div>
                        <div class="cart_info_col cart_info_col_total">Total</div>
                    </div>
                </div>
            </div>
            <div class="row cart_items_row">
                <div id="cartItems" class="col">

                    <!-- Cart Item -->
                    @foreach(session()->get('cart') as $item)
                    <div class="cart_item d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
                        <!-- Name -->
                        <div class="cart_item_product d-flex flex-row align-items-center justify-content-start">
                            <div class="cart_item_image">
                                <div><img src="{{asset("uv-public/images/$item->image")}}" alt=""></div>
                            </div>
                            <div class="cart_item_name_container">
                                <div class="cart_item_name"><a href="{{url($item->permalink)}}">{{$item->productName}}</a></div>
                                <div class="cart_item_edit"><a href="#">Remove</a></div>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="cart_item_price">${{$item->price}}</div>
                        <!-- Quantity -->
                        <div class="cart_item_quantity">
                            <div class="product_quantity_container">
                                <div class="product_quantity clearfix">
                                    <span>Qty</span>
                                    <input class="cart-product-quantity" type="number" style="width: 100%;" pattern="[0-9]*" data-productid="{{$item->productId}}" value="{{$item->quantity}}" max="{{$item->maxQuantity}}" min="1" onkeydown="return false">
                                </div>
                            </div>
                        </div>
                        <!-- Total -->
                        <div class="cart_item_total">${{$item->totalPrice}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row row_cart_buttons">
                <div class="col">
                    <div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
                        <div class="button continue_shopping_button"><a href="#">Continue shopping</a></div>
                        <div class="cart_buttons_right ml-lg-auto">
                            <div class="button clear_cart_button">
                                <form method="delete" id="clearCart">
                                    @csrf
                                    <input type="button" name="btnClearCart" id="btnClearCart" value="Clear cart"/>
                                </form>
                            </div>
{{--                            <div class="button update_cart_button"><a href="#">Update cart</a></div>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                <div class="billing checkout_section">
                    <div class="section_title">Billing Address</div>
                    <div class="section_subtitle">Enter your address info</div>
                <form action="#" method="POST" id="checkout_form" class="checkout_form">
{{--                    @if(session()->has('user'))--}}
{{--                        {{dd(session()->get('user'))}}--}}
{{--                        @endif--}}
                    @csrf
                    <div class="row checkout_form_container">
                        <div class="col-xl-6">
                            <!-- Name -->
                            <label for="checkout_name">First Name*</label>
                            <input type="text" id="firstname" name="firstname" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->firstName}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6 last_name_col">
                            <!-- Last Name -->
                            <label for="checkout_last_name">Last Name*</label>
                            <input type="text" id="lastname" name="lastname" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->lastName}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6">
                            <!-- Name -->
                            <label for="checkout_name">Email*</label>
                            <input type="text" id="email" name="email" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->email}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6 last_name_col">
                            <!-- Last Name -->
                            <label for="checkout_last_name">Phone*</label>
                            <input type="text" id="phone" name="phone" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->phone}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6">
                            <!-- Name -->
                            <label for="checkout_name">City*</label>
                            <input type="text" id="city" name="city" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->city}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6 last_name_col">
                            <!-- Last Name -->
                            <label for="checkout_last_name">Zip code*</label>
                            <input type="number" id="zip" name="zip" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->zipCode}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6">
                            <!-- Name -->
                            <label for="checkout_name">Street*</label>
                            <input type="text" id="street" name="street" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->street}}@else{{''}}@endif">
                        </div>
                        <div class="col-xl-6 last_name_col">
                            <!-- Last Name -->
                            <label for="checkout_last_name">Street number*</label>
                            <input type="text" id="streetNumber" name="streetNumber" class="checkout_input" required="required" value="@if(session()->has('user')){{session()->get('user')->streetNumber}}@else{{''}}@endif">
                        </div>
                    </div>

                </div>
                </div>
            </div>

            <div class="row row_extra">
                <div class="col-lg-4">

                    <!-- Delivery -->
                    <div class="delivery">
                        <div class="section_title">Courier</div>
                        <div class="section_subtitle">Select the one you want</div>
                        <div class="delivery_options">
                            @if($couriers)
                            @foreach($couriers as $courier)
                            <label class="delivery_option clearfix">{{$courier->name}}
                                <input type="radio" name="radio" value="{{$courier->id}}">
                                <span class="checkmark"></span>
                            </label>
                                <span class="delivery_price">{{$courier->description}}</span>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    @if(session()->has('user'))
                    <div class="coupon">
                        <div class="section_title">Coupon code</div>
                        <div class="section_subtitle">Enter your coupon code</div>
                        <div class="coupon_form_container">
                            <form action="#" id="coupon_form" class="coupon_form">
                                <input type="text" class="coupon_input" required="required">
                                <button class="button coupon_button"><span>Apply</span></button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-6 offset-lg-2">
                    <div class="cart_total">
                        <div class="section_title">Cart total</div>
                        <div class="section_subtitle">Final info</div>
                        <div class="cart_total_container">
{{--                            <div class="payment">--}}
{{--                                <div class="section_title">Payment type</div>--}}
{{--                                <div class="section_subtitle">Select the one you want</div>--}}
{{--                                <div class="payment_options">--}}
{{--                                    @if($paymentTypes)--}}
{{--                                        @foreach($paymentTypes as $paymentType)--}}
{{--                                            <li class="d-flex flex-row align-items-center justify-content-start">--}}
{{--                                            <label class="payment_option clearfix">{{$paymentType->name}}--}}
{{--                                                <input type="radio" name="paymentType" value="{{$paymentType->code}}">--}}
{{--                                                <span class="checkmark"></span>--}}
{{--                                            </label>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <ul>
                                @if($paymentTypes)
                                    <li class="d-flex flex-row align-items-center justify-content-start">
                                        <div class="cart_total_title"><strong>Payment type</strong></div>
                                    </li>
                                    @foreach($paymentTypes as $paymentType)
                                        <li class="d-flex flex-row align-items-center justify-content-start">
                                            <label class="payment_option clearfix">{{$paymentType->name}}
                                                <input type="radio" name="paymentType" value="{{$paymentType->code}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                @endif
                                <li class="d-flex flex-row align-items-center justify-content-start">
                                    <div class="cart_total_title">Subtotal</div>
                                    <div class="cart_total_value ml-auto">${{$totalCartPrice}}</div>
                                </li>
                                <li class="d-flex flex-row align-items-center justify-content-start">
                                    <div class="cart_total_title">Shipping</div>
                                    <div class="cart_total_value ml-auto">@if ($courierPrice == 0) Free @else ${{$courierPrice}} @endif</div>
                                </li>
                                <li class="d-flex flex-row align-items-center justify-content-start">
                                    <div class="cart_total_title">Total</div>
                                    <div class="cart_total_value ml-auto">${{$totalForPay}}</div>
                                </li>
                            </ul>

                        </div>

                        <div class="button checkout_button"><a href="#">Make order</a></div>
                        </form>
                    </div>
                </div>
            </div>
            @else

                <div class="row row_cart_buttons">
                    <div class="col">
                        <div class="alert alert-danger">
                            There is no products in cart.
                        </div>
                        <div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
                            <div class="button continue_shopping_button"><a href="{{url('/products')}}">Continue shopping</a></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('uv-public/js/cart.js')}}"></script>
@endsection
