<?php use App\Http\Controllers\Website\OrderController;?>

@extends('enzo_site.layout')

@section('content')
    <!-- banner -->
    <div class="" id="">
        <div class="container">

        </div>
    </div>
    <!-- //banner -->

    <form action="{{ route('place_order') }}" method="post">

        {{ csrf_field() }}

        <div class="checkout">
            <div class="container">
                @if(Session::has('invalid_order_msg'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('invalid_order_msg') }}</p>
                @endif

                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
                @endif

                <h3>Your shopping cart contains: <span>{{ $count_cart_items }} Products</span></h3>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th class="text-center">Product Image</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Color</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        @php
                            $sl = 1;
                            $amount = 0;
                            $total_amount = 0;
                            $shipment_charge = ($company_info[0]->shipment_charge <> "" ? $company_info[0]->shipment_charge : 0);
                            $vat_percentage = ($company_info[0]->vat_percentage <> "" ? $company_info[0]->vat_percentage : 0);
                        @endphp

                        @foreach($cart_items as $k => $cart_item)
                            <tr>
                                <td class="text-center">{{ $sl }}</td>
                                <td align="center">
                                    @php
                                        $get_single_product_image = OrderController::getSingleProductImageByColor($cart_item['product_id'], $cart_item['color_id']);
                                    @endphp

                                    {{--<a href="{{ route('view_single_product', [$cart_item['product_id'], $cart_item['color_id']]) }}">--}}
                                        <img src="{{ asset('storage/uploads/'.$get_single_product_image[0]->image_url) }}" alt="{{ $cart_item['product_name'] }}" class="img-responsive" width="80" height="" />
                                    {{--</a>--}}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('view_single_product', [$cart_item['product_id'], $cart_item['color_id']]) }}">
                                        {{ $cart_item['product_name'] }}
                                    </a>
                                    <input type="hidden" name="product_id[]" value="{{ $cart_item['product_id'] }}">
                                </td>
                                <td class="text-center">
                                    {{ $cart_item['color'] }}
                                    <input type="hidden" name="color_id[]" value="{{ $cart_item['color_id'] }}">
                                </td>
                                <td class="text-center">
                                    {{ $cart_item['size_name'].' - '.$cart_item['size_description'] }}
                                    <input type="hidden" name="size_id[]" value="{{ $cart_item['size_id'] }}">
                                </td>
                                <td class="text-center">
                                    {{ $cart_item['qty'] }}
                                    <input type="hidden" name="quantity[]" value="{{ $cart_item['qty'] }}" readonly="readonly">
                                </td>
                                <td class="text-center">
                                    ৳ {{ $cart_item['price_in_bdt'] }}

                                    @php
                                        $amount = $cart_item['qty'] * $cart_item['price_in_bdt'];
                                        $total_amount += $amount;
                                    @endphp

                                    <input type="hidden" name="price[]" value="{{ $cart_item['price_in_bdt'] }}">
                                </td>
                                <td class="text-center">
                                    {{--<a class="btn btn-sm btn-danger" onclick="productRemovingConfirmation('{{ $k }}');" href="{{ route('remove_from_cart', $k) }}">--}}
                                    <span class="btn btn-sm btn-danger" onclick="productRemovingConfirmation('{{ $k }}');">
                                        <i class="fas fa-trash"></i>
                                    </span>
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

                @if($count_cart_items > 0)

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="2" style="background-color: #ff9b05; color: #ffffff;">
                                                    <h4>Summary</h4>
                                                    <input type="hidden" name="invoice_no" value="{{ $invoice_no }}">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="45%"><b>Total Amount</b></th>
                                                <td class="text-left" width="55%"><span>৳ {{ $total_amount }} </span><input type="hidden" name="total_amount" value="{{ $total_amount }}" readonly="readonly"></td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="45%"><b>Shipment Charge</b></th>
                                                <td class="text-left" width="55%"><span>৳ {{ $shipment_charge }} </span><input type="hidden" name="shipment_charge" value="{{ $shipment_charge }}" readonly="readonly"></td>
                                            </tr>

                                            @php

                                                $vat_amount = 0;
                                                if($total_amount > 0){
                                                    $vat_amount = ($total_amount * ($vat_percentage/100));
                                                }

                                            @endphp

                                            <tr>
                                                <th class="text-right" width="45%"><b>VAT(15%)</b></th>
                                                <td class="text-left" width="55%"><span>৳ {{ $vat_amount }} </span><input type="hidden" name="vat_amount" value="{{ $vat_amount }}" readonly="readonly"></td>
                                            </tr>

                                            @php

                                                $net_amount =0;
                                                $net_amount = round($total_amount + $vat_amount + $shipment_charge);

                                            @endphp

                                            <tr>
                                                <th class="text-right" width="45%"><b>Net Amount</b></th>
                                                <td class="text-left" width="55%"><span>৳ {{ $net_amount }}</span><input type="hidden" name="net_amount" value="{{ $net_amount }}" readonly="readonly"></td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="45%"><b>Payment Method</b> <span style="color: red;">*</span></th>
                                                <td class="text-left" width="55%">
                                                    <select class="form-control" name="payment_method" id="payment_method" required="required">
                                                        <option value="">Payment Method</option>
                                                        <option value="1">Cash on Delivery</option>
                                                        <option value="2">e-Payment</option>
                                                    </select>
                                                </td>
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
                                                <th class="text-center" style="background-color: #669dff; color: #ffffff;">
                                                    <h4>Shipping Information</h4>
                                                </th>
                                                <th class="text-center" style="background-color: #669dff; color: #ffffff;">
                                                    Same As Profile <input type="checkbox" name="same_as_profile" id="same_as_profile" onclick="getCustomerProfileInfo();">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="30%"><b>Contact Person Name <span style="color: red">*</span></b></th>
                                                <td class="text-left" width="70%">
                                                    <input type="text" class="form-control" name="contact_person_name" id="contact_person_name" required="required">
                                                    <span id="customer_name" style="display: none;">{{ $customer_info->full_name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="30%"><b>Contact No. <span style="color: red">*</span></b></th>
                                                <td class="text-left" width="70%">
                                                    <input type="text" class="form-control" name="contact_person_contact_no" id="contact_person_contact_no" required="required">
                                                    <span id="customer_contact_no" style="display: none;">{{ $customer_info->contact_no }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" width="30%"><b>Email</b></th>
                                                <td class="text-left" width="70%">
                                                    <input type="text" class="form-control" name="contact_person_email" id="contact_person_email" required="required">
                                                    <span id="customer_email" style="display: none;">{{ $customer_info->email }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-right text-top" width="30%"><b>Shipping Address <span style="color: red">*</span></b></th>
                                                <td class="text-left" width="70%">
                                                    <textarea type="text" class="form-control" name="contact_person_shipping_address" id="contact_person_shipping_address" required="required"></textarea>
                                                    <span id="customer_shipping_address" style="display: none;">{{ $customer_info->address }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="2"><button class="btn btn-lg btn-success">PLACE ORDER</button></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </form>

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
        
        function getCustomerProfileInfo() {
            var same_as_profile = $("#same_as_profile").val();

            var customer_name = $("#customer_name").text();
            var customer_contact_no = $("#customer_contact_no").text();
            var customer_email = $("#customer_email").text();
            var customer_shipping_address = $("#customer_shipping_address").text();

            if($("#same_as_profile").prop("checked") == true){
                $("#contact_person_name").val(customer_name);
                $("#contact_person_contact_no").val(customer_contact_no);
                $("#contact_person_email").val(customer_email);
                $("#contact_person_shipping_address").val(customer_shipping_address);
            }
            else if($("#same_as_profile").prop("checked") == false){
                $("#contact_person_name").val('');
                $("#contact_person_contact_no").val('');
                $("#contact_person_email").val('');
                $("#contact_person_shipping_address").val('');
            }
        }

    </script>

@endsection