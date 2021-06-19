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

            @php

                $order_status = $orders[0]->status;

            @endphp

            <div class="progress" style="height: auto;">
                <div class="progress-bar progress-bar-striped @if($order_status == 1) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="Order Received" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    Order Received
                </div>
                <div class="progress-bar progress-bar-striped @if($order_status == 2) progress-bar-success @else active @endif" role="progressbar"
                     aria-valuenow="Processing" aria-valuemin="0" aria-valuemax="100" style="width:25%; font-weight: 700">
                    Processing
                </div>
                <div class="progress-bar progress-bar-striped @if($order_status == 3) progress-bar-success @else active @endif" role="progressbar"
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
                                    {{ $order->product_name }}
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


            @if(!empty($orders[0]->shipment_by))
                <div class="checkout-left">
                    <div class="checkout-left-basket">
                        <h4 style="background-color: #5cd817">Shipment Info</h4>
                        <ul>
                            <li>{{ $orders[0]->shipment_by }} <i>-</i> <span>{{ $orders[0]->shipment_remarks }} </span></li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{--Modal--}}
    <div class="modal video-modal fade" id="modalProductRemoveConfirmation" tabindex="-1" role="dialog" aria-labelledby="modalProductRemoveConfirmation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h3>Are you sure to remove the product from cart?</h3>
                    <input type="hidden" name="cart_item_to_remove" id="cart_item_to_remove">
                    <div class="clearfix"> </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-success" onclick="removeProductFromCart()">Yes</span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>

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

@endsection