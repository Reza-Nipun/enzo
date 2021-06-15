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
                        $total_amount = 0;
                        $shipment_charge = 100;
                        $vat_percentage = 15;
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
                            </td>
                            <td class="text-center">
                                {{ $cart_item['color'] }}
                            </td>
                            <td class="text-center">{{ $cart_item['size_name'].' - '.$cart_item['size_description'] }}</td>
                            <td class="text-center">
                                {{ $cart_item['qty'] }}

                                {{--<div class="quantity">--}}
                                {{--<div class="quantity-select">--}}
                                {{--<div class="entry value-minus">&nbsp;</div>--}}
                                {{--<div class="entry value"><span>{{ $cart_item['qty'] }}</span></div>--}}
                                {{--<div class="entry value-plus active">&nbsp;</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </td>
                            <td class="text-center">৳ {{ $cart_item['price_in_bdt'] }}</td>
                            <td class="text-center">
                                {{--<a class="btn btn-sm btn-danger" onclick="productRemovingConfirmation('{{ $k }}');" href="{{ route('remove_from_cart', $k) }}">--}}
                                <span class="btn btn-sm btn-danger" onclick="productRemovingConfirmation('{{ $k }}');">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </td>
                        </tr>

                        @php
                            $sl++;
                            $total_amount += $cart_item['price_in_bdt'];
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

                <div class="checkout-left">
                    <div class="checkout-left-basket">
                        <h4>Summary</h4>
                        <ul>
                            <li>Total Amount <i>-</i> <span>৳ {{ $total_amount }} </span></li>
                            <li>Shipment Charge <i>-</i> <span>৳ {{ $shipment_charge }} </span></li>

                            @php

                                $vat_amount = 0;
                                if($total_amount > 0){
                                    $vat_amount = (($vat_percentage/100) / $total_amount);
                                }

                            @endphp

                            <li>VAT(15%) <i>-</i> <span>৳ {{ $vat_amount }} </span></li>

                            @php

                                $net_amount =0;
                                $net_amount = ($total_amount + $vat_amount + $shipment_charge);

                            @endphp

                            <li>Net Amount <i>-</i> <span>৳ {{ $net_amount }}</span></li>
                            <li><select class="form-control"><option value="">Payment Type</option><option>e-Payment</option><option>Cash on Delivery</option></select></li>
                        </ul>
                        <br />
                        <button class="btn btn-lg btn-success">PLACE ORDER</button>
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