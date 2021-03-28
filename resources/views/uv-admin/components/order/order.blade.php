@extends('uv-admin.layouts.adminlayout')
@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                    <h3 class="title-5 m-b-35">Order</h3>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>add order</button>
                    </div>
                    </div>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--md">
                                <label for="cc-payment" class="control-label sm-1">Status</label>
                                <select class="js-select2" name="property">
                                    <option>All</option>
                                    @foreach($statusFilterArray as $key => $status)
                                    <option value="{{$key}}">{{$status}}</option>
                                    @endforeach
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <div class="rs-select2--light rs-select2--md">
                                <label for="cc-payment" class="control-label sm-1">Delete</label>
                                <select class="js-select2" name="property">
                                    <option>All</option>
                                    @foreach($deleteFilterArray as $key => $delete)
                                        <option value="{{$key}}">{{$delete}}</option>
                                    @endforeach
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <div class="rs-select2--light rs-select2--sm">
                                <label for="cc-payment" class="control-label sm-1">Sent</label>
                                <select class="js-select2" name="time">
                                    <option>All</option>
                                    @foreach($yesNoArray as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                            <div class="rs-select2--light rs-select2--sm">
                                <label for="cc-payment" class="control-label sm-1">Order id</label>
                                <input id="o_orderId" name="cc-payment" type="text" class="form-control">
                            </div>
                            <div class="rs-select2--light rs-select2--lg">
                                <label for="o_dateFrom" class="control-label sm-1">Date from</label>
                                <input id="o_dateFrom" name="cc-payment" type="date" class="form-control">
                            </div>
                            <div class="rs-select2--light rs-select2--lg">
                                <label for="o_dateTo" class="control-label sm-1">Date to</label>
                                <input id="o_dateTo" name="cc-payment" type="date" class="form-control">
                            </div>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-export"></i>export to excel</button>
                            <button type="submit" class="btn btn-success btn-md">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                        </div>

                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>user info</th>
                                <th>payment</th>
                                <th>date</th>
                                <th>status</th>
                                <th>postage</th>
                                <th>price</th>
                                <th>ransom</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($records && count($records) > 0)
                                @foreach($records as $record)
                                <tr class="tr-shadow">
                                    <td>{{$record->id}}</td>
                                    <td>
                                        <span>{{$record->firstName}} {{$record->lastName}}</span><br/>
                                        <span class="block-email">{{$record->email}}</span><br/>
                                        <span>{{$record->street}} {{$record->streetNumber}}</span><br/>
                                        <span>{{$record->zipCode}} {{$record->city}}</span>
                                    </td>
                                    <td class="desc"><span class="badge badge-primary">{{$record->paymentType}}</span></td>
                                    <td>{{$record->dateCreate}}</td>
                                    <td>
                                        <span class="status--process">Processed</span>
                                    </td>
                                    <td>${{$record->postage}}</td>
                                    <td>${{$record->price}}</td>
                                    <td>${{$record->ransom}}</td>
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
                    <div class="d-flex justify-content-center">

                        {{$records->links("pagination::bootstrap-4")}}

                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
            <!-- FOOTER-->

            <!-- END FOOTER-->
        </div>
    </div>
@endsection
