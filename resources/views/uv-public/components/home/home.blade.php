@extends('uv-public.layouts.homelayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/responsive.css')}}">
@endsection
@section('products')
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="product_grid" id="productshome">

                    <!-- Product -->

                    @foreach($products as $product)
                        <div class="product">
                            <div class="product_image"><img src="{{asset("uv-public/images/$product->image")}}" alt=""></div>
                            @if($product->actionId != -1)
                                <div class="product_extra {{$product->class}}"><a href="{{url("/$product->categoryPermalink/$product->permalink")}}">{{$product->name}}</a></div>
                            @endif
                            <div class="product_content">

                                <div class="product_title"><a href="{{url("/$product->categoryPermalink/$product->permalink")}}">{{$product->title}}</a></div>
                                <div class="product_price">${{$product->price}}</div>
                            </div>
                        </div>
                    @endforeach


                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset("uv-public/js/custom.js")}}"></script>
@endsection
