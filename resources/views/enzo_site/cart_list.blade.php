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

                <h3>Your shopping cart contains: <span>{{ $count_cart_items }} Products</span></h3>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            {{--<th>Image</th>--}}
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
                                {{--<td class="invert-image">--}}
                                    {{--@php--}}
                                        {{--$get_single_product_image = OrderController::getSingleProductImageByColor($cart_item['product_id'], $cart_item['color_id']);--}}
                                    {{--@endphp--}}

                                    {{--<a href="{{ route('view_single_product', [$cart_item['product_id'], $cart_item['color_id']]) }}">--}}
                                        {{--<img src="{{ asset('storage/uploads/'.$get_single_product_image[0]->image_url) }}" alt="{{ $cart_item['product_name'] }}" class="img-responsive" />--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                <td>
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

                                    <input type="hidden" name="price[]" value="{{ $amount }}">
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

                    <input type="hidden" name="invoice_no" value="{{ $invoice_no }}">

                    <div class="checkout-left">
                        <div class="checkout-left-basket">
                            <h4>Summary</h4>
                            <ul>
                                <li>Total Amount <i>-</i> <span>৳ {{ $total_amount }} </span><input type="hidden" name="total_amount" value="{{ $total_amount }}" readonly="readonly"></li>
                                <li>Shipment Charge <i>-</i> <span>৳ {{ $shipment_charge }} </span><input type="hidden" name="shipment_charge" value="{{ $shipment_charge }}" readonly="readonly"></li>

                                @php

                                    $vat_amount = 0;
                                    if($total_amount > 0){
                                        $vat_amount = ($total_amount * ($vat_percentage/100));
                                    }

                                @endphp

                                <li>VAT(15%) <i>-</i> <span>৳ {{ $vat_amount }} </span><input type="hidden" name="vat_amount" value="{{ $vat_amount }}" readonly="readonly"></li>

                                @php

                                    $net_amount =0;
                                    $net_amount = ($total_amount + $vat_amount + $shipment_charge);

                                @endphp

                                <li>Net Amount <i>-</i> <span>৳ {{ $net_amount }}</span><input type="hidden" name="net_amount" value="{{ $net_amount }}" readonly="readonly"></li>
                                {{--<li><select class="form-control"><option value="">Payment Type</option><option>e-Payment</option><option>Cash on Delivery</option></select></li>--}}
                            </ul>
                            <br />
                            <button class="btn btn-lg btn-success">PLACE ORDER</button>
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

    </script>

@endsection