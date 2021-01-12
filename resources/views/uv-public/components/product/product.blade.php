@extends('uv-public.layouts.pageslayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/product.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/product_responsive.css")}}">
@endsection
@section('content')
    <div class="product_details">
        <div class="container">
            <div class="row details_row">

                <!-- Product Image -->
                <div class="col-lg-6">
                    <div class="details_image">
                        @php
                            $image = $product[0]->image;
                        @endphp
                        <div class="details_image_large"><img src="{{asset("uv-public/images/$image")}}" alt="{{$product[0]->title}}">
                            @if($product[0]->actionId != -1)<div class="product_extra {{$product[0]->class}}"><a>{{$product[0]->name}}</a></div>@endif
                        </div>
                        <div class="details_image_thumbnails d-flex flex-row align-items-start justify-content-between">
                            <div class="details_image_thumbnail active" data-image="{{asset("uv-public/images/$image")}}"><img src="{{asset("uv-public/images/$image")}}" alt=""></div>
                            @foreach($images as $image)

                            <div class="details_image_thumbnail" data-image="{{asset("uv-public/images/$image->file")}}"><img src="{{asset("uv-public/images/$image->file")}}" alt=""></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Content -->
                <div class="col-lg-6">
                    <div class="details_content">
                        <div class="details_name">{{$product[0]->title}}</div>
                        @if($product[0]->oldPrice)
                        <div class="details_discount">${{$product[0]->oldPrice}}</div>
                        @endif
                        <div class="details_price">${{$product[0]->price}}</div>

                        <!-- In Stock -->
                        @if($product[0]->quantity <= 2)
                        <div class="in_stock_container">
                            <div class="availability">Availability:</div>
                            <span class="text-danger">Out of stock</span>
                        </div>
                        @else
                        <div class="in_stock_container" >
                            <div class="availability">Availability:</div>
                            <span>{{$maxQuantity}} @if($maxQuantity == 1) product @else products @endif in stock</span>
                        </div>
                        @endif
                        <div class="details_text">
                            <p>{{$product[0]->shortDescription}}</p>
                        </div>

                        <!-- Product Quantity -->
                        <div class="product_quantity_container">
                            <form action="{{url()->current()}}" method="post" id="product_form">
                            @csrf
                            <div class="product_quantity clearfix">
                                <span>Qty</span>
                                @php
                                    $id = $product[0]->id;
                                @endphp
                                    <input id="quantity" name="quantity" type="number" style="width: 100%;" pattern="[0-9]*" value="0" max="{{$maxQuantity}}" min="0" onkeydown="return false"/>
                                    <input id="productId" name="productId" type="hidden" style="width: 100%;" pattern="[0-9]*" value="{{$id}}">
                                    <input id="maxQuantity" name="maxQuantity" type="hidden" style="width: 100%;" pattern="[0-9]*" value="{{$maxQuantity}}">
                            </div>
                            @if($product[0]->quantity > 2)
                            <div class="button cart_button">
                                <input type="button" id="btnAddToCart" name="btnAddToCart" value="Add to cart"/>
                            </div>
                            @else
                                <span class="text-info">Product will be available soon.</span>
                            @endif
                            </form>
                            <div style="margin-top: 10px;">
                                <span id="cartInfo" ></span>
                            </div>
                        </div>

                        <!-- Share -->
                        <div class="details_share">
                            <span>Find us:</span>
                            <ul>
                                <li><a href="{{url('https://www.pinterest.com/')}}" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                <li><a href="{{url('https://www.instagram.com/')}}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="{{url('https://www.facebook.com/')}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="{{url('https://www.twitter.com/')}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row description_row">
                <div class="col">
                    <div class="description_title_container">
                        <div class="description_title">Description</div>
                    </div>
                    <div class="description_text">
                        <p>{{$product[0]->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->

    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="products_title">Related Products</div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="product_grid">

                        <!-- Product -->
                        @if(count($relatedProducts))
                        @foreach($relatedProducts as $product)
                            <div class="product">
                                <div class="product_image"><img src="{{asset("uv-public/images/$product->image")}}" alt=""></div>
                                @if($product->actionId != 4)
                                    <div class="product_extra {{$product->class}}"><a href="{{url("/$product->categoryPermalink/$product->permalink")}}">{{$product->name}}</a></div>
                                @endif
                                <div class="product_content">
                                    <div class="product_title"><a href="{{url("/$product->categoryPermalink/$product->permalink")}}">{{$product->title}}</a></div>
                                    <div class="product_price">${{$product->price}}</div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <h3>No related products.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset("uv-public/js/product.js")}}"></script>
@endsection
