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
            <h2>Order History</h2>
            <br />

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Order No</th>
                        <th class="text-center">Net Amount</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Shipment Info</th>
                        <th class="text-center">Order Date</th>
                        <th class="text-center">Status</th>
                    </tr>
                    </thead>

                    @foreach($orders as $k => $order)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('order_detail', $order->invoice_no) }}">
                                    {{ $order->invoice_no }}
                                </a>
                            </td>
                            <td class="text-center">
                                ৳ {{ $order->net_amount }}
                            </td>
                            <td class="text-center">
                                {{ ($order->payment_status == 1 ? 'Paid' : 'Not Paid') }}
                            </td>
                            <td class="text-center">
                                {{ $order->shipment_by.($order->shipment_remarks != '' ? ' - '.$order->shipment_remarks : '') }}
                            </td>
                            <td class="text-center">
                                {{ date('Y-m-d', strtotime($order->created_at)) }}
                            </td>
                            <td class="text-center">

                                @if($order->status == 0)
                                    <span class="badge badge-danger">Cancelled</span>
                                @elseif($order->status == 1)
                                    <span class="badge badge-warning">Order Received</span>
                                @elseif($order->status == 2)
                                    <span class="badge badge-warning">Processing</span>
                                @elseif($order->status == 3)
                                    <span class="badge badge-warning">On Shipment</span>
                                @elseif($order->status == 4)
                                    <span class="badge badge-success">Delivered</span>
                                @endif

                            </td>
                        </tr>

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
            <div class="row text-center">
                {{ $orders->links() }}
            </div>
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