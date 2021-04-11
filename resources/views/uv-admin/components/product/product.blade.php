@extends('uv-admin.layouts.adminlayout')
@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <h3 class="title-5 m-b-35">Product</h3>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add product</button>
                        </div>
                    </div>
                    <form action="{{url()->current()}}" method="post" id="product_form">
                        @csrf
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                                <div class="rs-select2--light rs-select2--md">
                                    <label for="cc-payment" class="control-label sm-1">Status</label>
                                    <select id="p_status" name="p_status" class="js-select2" name="property">
                                        <option value="0">All</option>
                                        @foreach($statusFilterArray as $key => $status)
                                            <option value="{{$key}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <div class="rs-select2--light rs-select2--md">
                                    <label for="cc-payment" class="control-label sm-1">Delete</label>
                                    <select id="p_del" name="p_del"  class="js-select2" name="property">
                                        <option value="0">All</option>
                                        @foreach($deleteFilterArray as $key => $delete)
                                            <option value="{{$key}}">{{$delete}}</option>
                                        @endforeach
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <div class="rs-select2--light rs-select2--sm">
                                    <label for="p_productId" class="control-label sm-1">Product id</label>
                                    <input id="p_productId" name="p_productId" type="text" class="form-control">
                                </div>
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-export"></i>export to excel</button>
                                <button id="p_filter" name="p_filter" type="submit" class="btn btn-success btn-md">
                                    <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>

                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>image</th>
                                    <th>name</th>
                                    <th>category</th>
                                    <th>quantity</th>
                                    <th>price</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="product_table">
                                @if($records && count($records) > 0)
                                    @foreach($records as $record)
                                        <tr class="tr-shadow">
                                            <td>{{$record->id}}</td>
                                            <td>
                                                <img width="100px" height="100px" alt="{{$record->title}}" src="{{asset("uv-public/images/".$record->image)}}" />
                                            </td>
                                            <td class="desc">{{$record->title}}</td>
                                            <td>{{$record->categoryName}}</td>
                                            <td>{{$record->quantity}}</td>
                                            <td>${{$record->price}}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-id="{{$record->id}}" data-toggle="tooltip" data-placement="top" title="Send">
                                                        <i class="zmdi zmdi-mail-send"></i>
                                                    </button>
                                                    <button class="item" data-id="{{$record->id}}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-id="{{$record->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center" id="p_pagination">

                            {{$records->links("pagination::bootstrap-4")}}

                        </div>
                        <input id="p_page" name="p_page" type="hidden" class="form-control" value="1">
                    </form>
                    <!-- END DATA TABLE -->
                </div>
            </div>
            <!-- FOOTER-->

            <!-- END FOOTER-->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset("uv-admin/js/product.js")}}"></script>
@endsection
