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

            <div class="checkout-right">
                <table class="timetable_sub">
                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Remove</th>
                    </tr>
                    </thead>

                    @php
                        $sl = 1;
                    @endphp

                    @foreach($cart_items as $k => $cart_item)
                        <tr class="rem1">
                            <td class="invert">{{ $sl }}</td>
                            <td class="invert-image">
                                @php
                                    $get_single_product_image = OrderController::getSingleProductImageByColor($cart_item['product_id'], $cart_item['color_id']);
                                @endphp

                                <a href="{{ route('view_single_product', [$cart_item['product_id'], $cart_item['color_id']]) }}">
                                    <img src="{{ asset('storage/uploads/'.$get_single_product_image[0]->image_url) }}" alt="{{ $cart_item['product_name'] }}" class="img-responsive" style="width: 100px; height: 100px" />
                                </a>
                            </td>
                            <td class="invert">
                                {{ $cart_item['product_name'] }}
                            </td>
                            <td class="invert">
                                {{ $cart_item['color'] }}
                            </td>
                            <td class="invert">{{ $cart_item['size_name'].' '.$cart_item['size_description'] }}</td>
                            <td class="invert">
                                {{ $cart_item['qty'] }}

                                {{--<div class="quantity">--}}
                                {{--<div class="quantity-select">--}}
                                {{--<div class="entry value-minus">&nbsp;</div>--}}
                                {{--<div class="entry value"><span>{{ $cart_item['qty'] }}</span></div>--}}
                                {{--<div class="entry value-plus active">&nbsp;</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </td>
                            <td class="invert">৳ {{ $cart_item['price_in_bdt'] }}</td>
                            <td class="invert">
                                <a class="btn btn-sm btn-danger" href="{{ route('remove_from_cart', $k) }}">
                                    <i class="fas fa-trash"></i>
                                </a>
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
            <div class="checkout-left">
                <div class="checkout-left-basket">
                    <h4>Continue to basket</h4>
                    <ul>
                        <li>Product1 <i>-</i> <span>$200.00 </span></li>
                        <li>Product2 <i>-</i> <span>$270.00 </span></li>
                        <li>Product3 <i>-</i> <span>$212.00 </span></li>
                        <li>Total Service Charges <i>-</i> <span>$15.00</span></li>
                        <li>Total <i>-</i> <span>$697.00</span></li>
                    </ul>
                </div>
                <div class="checkout-right-basket">
                    <a href="products.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

@endsection