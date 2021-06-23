<?php use App\Http\Controllers\Website\OrderController;?>

@extends('enzo_site.layout')

@section('content')
    <!-- banner -->
    <div class="" id="">
        <div class="container">

        </div>
    </div>
    <!-- //banner -->

    <div class="checkout">
        <div class="container">
            <h2>Order# {{ $invoice_no }}</h2>
            <br />

            @if(Session::has('invalid_order_msg'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('invalid_order_msg') }}</p>
            @endif

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            @if(count($errors))
                <div class="form-group">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @php

                $order_status = $orders[0]->status;

            @endphp

            <div class="progress" style="height: auto;">
                <div class="progress-bar progress-bar-striped @if($order_status == 1 || $order_status == 2 || $order_status == 3 || $order_status == 4) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="Order Received" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    Order Received
                </div>
                <div class="progress-bar progress-bar-striped @if($order_status == 2 || $order_status == 3 || $order_status == 4) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="Processing" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    Processing
                </div>
                <div class="progress-bar progress-bar-striped @if($order_status == 3 || $order_status == 4) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="On Shipment" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    On Shipment
                </div>
                <div class="progress-bar progress-bar-striped @if($order_status == 4) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="Delivered" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    Delivered
                </div>
            </div>

            {{--<div class="progress">--}}
                {{--<div class="progress-bar progress-bar-success" role="progressbar" style="width:40%">--}}
                    {{--Free Space--}}
                {{--</div>--}}
                {{--<div class="progress-bar progress-bar-warning" role="progressbar" style="width:10%">--}}
                    {{--Warning--}}
                {{--</div>--}}
                {{--<div class="progress-bar progress-bar-danger" role="progressbar" style="width:20%">--}}
                    {{--Danger--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        @if($order_status == 4)
                            <th class="text-center">Review</th>
                        @endif
                    </tr>
                    </thead>

                    @php
                        $sl = 1;
                        $amount = 0;
                        $total_amount = 0;
                        $shipment_charge = ($company_info[0]->shipment_charge <> "" ? $company_info[0]->shipment_charge : 0);
                        $vat_percentage = ($company_info[0]->vat_percentage <> "" ? $company_info[0]->vat_percentage : 0);
                    @endphp

                    @foreach($order_detail as $order)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('view_single_product', [$order->product_id, $order->color_id]) }}" target="_blank">
                                    {{ $order->product_name.' '.$order->order_id }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $order->color }}
                            </td>
                            <td class="text-center">
                                {{ $order->size.' - '.$order->size_description }}
                            </td>
                            <td class="text-center">
                                {{ $order->quantity }}
                            </td>
                            <td class="text-center">
                                ৳ {{ $order->price }}
                            </td>
                            @if($order_status == 4)
                                <td class="text-center">
                                    @if(!empty($order->rating))
                                        <input class="rating-input" type="text" title="" value="{{ $order->rating }}" disabled="disabled"/>
                                    @else
                                        <input class="rating-input" type="text" title="" onchange="getProductComment($(this).val(), '{{ $order->product_id }}', '{{ $order->color_id }}', '{{ $order->order_id }}', '{{ $order->customer_id }}')"/>
                                    @endif
                                </td>
                            @endif
                        </tr>

                        @php
                            $sl++;
                        @endphp

                    @endforeach

                    <!--quantity-->
                    <script>
                        $('.value-plus').on('click', function(){
                            var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
                            divUpd.text(newVal);
                        });

                        $('.value-minus').on('click', function(){
                            var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
                            if(newVal>=1) divUpd.text(newVal);
                        });
                    </script>
                    <!--quantity-->
                </table>
            </div>
                {{--<div class="checkout-left">--}}
                    {{--<div class="checkout-left-basket">--}}
                        {{--<h4>Summary</h4>--}}
                        {{--<ul>--}}
                            {{--<li>Total Amount <i>-</i> <span>৳ {{ $orders[0]->total_amount }} </span></li>--}}
                            {{--<li>Shipment Charge <i>-</i> <span>৳ {{ $orders[0]->shipment_charge }} </span></li>--}}
                            {{--<li>VAT(15%) <i>-</i> <span>৳ {{ $orders[0]->vat_amount }} </span></li>--}}
                            {{--<li>Net Amount <i>-</i> <span>৳ {{ $orders[0]->net_amount }}</span></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" colspan="2" style="background-color: #ff9b05; color: #ffffff;">
                                            <h4>Summary</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Total Amount</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $orders[0]->total_amount }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Shipment Charge</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $orders[0]->shipment_charge }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>VAT(15%)</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $orders[0]->vat_amount }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Net Amount</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $orders[0]->net_amount }}</span></td>
                                    </tr>

                                    @if(!empty($orders[0]->shipment_by))
                                        <tr>
                                            <th class="text-center" colspan="2" style="background-color: #5cd817; color: #ffffff;">
                                                <h4>Shipment Info</h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">
                                                {{ $orders[0]->shipment_by }}
                                            </th>
                                            <td class="text-center">
                                                {{ $orders[0]->shipment_remarks }}
                                            </td>
                                        </tr>
                                    @endif

                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="2" style="background-color: #669dff; color: #ffffff;">
                                                <h4>Shipping Information</h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="50%"><b>Contact Person Name</b></th>
                                            <td class="text-left" width="50%">
                                                <span id="customer_name">{{ $orders[0]->contact_person_name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="50%"><b>Contact No.</b></th>
                                            <td class="text-left" width="50%">
                                                <span id="customer_contact_no">{{ $orders[0]->contact_person_contact_no }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="50%"><b>Email</b></th>
                                            <td class="text-left" width="50%">
                                                <span id="customer_email">{{ $orders[0]->contact_person_email }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right text-top" width="50%"><b>Shipping Address</b></th>
                                            <td class="text-left" width="50%">
                                                <span id="customer_shipping_address">{{ $orders[0]->contact_person_shipping_address }}</span>
                                            </td>
                                        </tr>
                                        @if($orders[0]->shipment_by != '')
                                            <tr>
                                                <th class="text-right text-top" width="50%"><b>Shipping By <span style="color: red">*</span></b></th>
                                                <td class="text-left" width="50%">
                                                    <span id="customer_shipping_address">{{ $orders[0]->shipment_by.($orders[0]->shipment_remarks != '' ? ' ('.$orders[0]->shipment_remarks.')' : '') }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

    {{--Modal--}}
    <div class="modal video-modal fade" id="product_review" tabindex="-1" role="dialog" aria-labelledby="product_review">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('product_review') }}" method="post">

                    {{ csrf_field() }}

                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id" readonly="readonly">
                        <input type="hidden" name="customer_id" id="customer_id" readonly="readonly">
                        <input type="hidden" name="product_id" id="product_id" readonly="readonly">
                        <input type="hidden" name="color_id" id="color_id" readonly="readonly">
                        <input type="hidden" name="product_rating" id="product_rating" readonly="readonly">

                        <h4>Product Review <span style="color: red;">*</span></h4>
                        <textarea name="product_review" id="product_review" class="form-control" required="required"></textarea>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">SAVE</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $( document ).ready(function() {

        });

        function productRemovingConfirmation(cart_item){

            $("#cart_item_to_remove").val(cart_item);
            $("#modalProductRemoveConfirmation").modal('show');

        }

        function removeProductFromCart() {
            var cart_item = $("#cart_item_to_remove").val();

            var url = '{{ route("remove_from_cart", ":cart_item") }}';
            url = url.replace(':cart_item', cart_item);

            document.location.href=url;
        }

    </script>

    {{--Rating Script Start--}}
    <script>
        jQuery(document).ready(function () {
            $("#input-21f").rating({
                starCaptions: function (val) {
                    if (val < 3) {
                        return val;
                    } else {
                        return 'high';
                    }
                },
                starCaptionClasses: function (val) {
                    if (val < 3) {
                        return 'label label-danger';
                    } else {
                        return 'label label-success';
                    }
                },
                hoverOnClear: false
            });
            var $inp = $('.rating-input');

            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'sm',
                showClear: false
            });

            $('#btn-rating-input').on('click', function () {
                $inp.rating('refresh', {
                    showClear: true,
                    disabled: !$inp.attr('disabled')
                });
            });


            $('.btn-danger').on('click', function () {
                $("#kartik").rating('destroy');
            });

            $('.btn-success').on('click', function () {
                $("#kartik").rating('create');
            });

            $inp.on('rating.change', function () {
                alert($('.rating-input').val());
            });


            $('.rb-rating').rating({
                'showCaption': true,
                'stars': '3',
                'min': '0',
                'max': '3',
                'step': '1',
                'size': 'xs',
                'starCaptions': {0: 'status:nix', 1: 'status:wackelt', 2: 'status:geht', 3: 'status:laeuft'}
            });
            $("#input-21c").rating({
                min: 0, max: 8, step: 0.5, size: "xl", stars: "8"
            });


        });

        function getProductComment(rating, product_id, color_id, order_id, customer_id) {
            $("#order_id").val(order_id);
            $("#customer_id").val(customer_id);
            $("#product_id").val(product_id);
            $("#color_id").val(color_id);
            $("#product_rating").val(rating);

            $("#product_review").modal('show');
        }
    </script>
    {{--Rating Script End--}}

@endsection