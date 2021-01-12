@extends('uv-public.layouts.pageslayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/categories.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("uv-public/styles/categories_responsive.css")}}">
@endsection
@section('content')
    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col">

                    <!-- Product Sorting -->
                    <div id="" class="sorting_bar d-flex flex-md-row flex-column align-items-md-center justify-content-md-start">
                        <div class="results">Showing <span id="count">{{count($products)}}</span>  <span id="countText">@if(count($products) == 1)result @else results @endif</span> </div>
                        <div class="sorting_container ml-md-auto">

                            <div class="sorting">

                                <form action="{{url()->current()}}" method="post" id="products_form">
                                    @csrf
                                    <span class="sorting_text" ><i class="glyphicon glyphicon-search"></i></span>
                                    <input type="text" class="search_input" id="search" name="search" value=""/>

                            </div>
                        </div>

                        <div class="sorting_container ml-md-auto">

                            <div class="sorting">

                                <span class="sorting_text" ><i class="glyphicon glyphicon-sort"></i></span>

                                <select class="search_input" id="sort" name="sort">
                                    <option class="product_sorting_btn" value="id.desc" data-isotope-option='{ "sortBy": "original-order" }'><span>Default</span></option>
                                    <option class="product_sorting_btn" value="price.asc" data-isotope-option='{ "sortBy": "price" }'><span>Price ASC</span></option>
                                    <option class="product_sorting_btn" value="price.desc" data-isotope-option='{ "sortBy": "price" }'><span>Price DESC</span></option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="product_grid">
                        <div id="products">

                            <!-- Product -->
                            @if(count($products) > 0)
                            @foreach($products as $product)
                                <div class="product col-lg-3">
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
                            <h3>No products for category.</h3>
                            @endif

                        </div>

                    </div>
                    @if(count($products) > 0)
                    <div class="product_pagination">
                        <div id="pag" class="button "><input type="button" id="btnPag" data-id="10" name="btnPag" value="Load more"/></div>
                    </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset("uv-public/js/categories.js")}}"></script>
@endsection
