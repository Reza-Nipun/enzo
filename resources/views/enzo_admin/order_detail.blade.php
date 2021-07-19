@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        {{--<div class="container-fluid">--}}
            {{--<div class="row mb-2">--}}
                {{--<div class="col-sm-6">--}}
                    {{--<h1></h1>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6">--}}
                    {{--<ol class="breadcrumb float-sm-right">--}}
                        {{--<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>--}}
                        {{--<li class="breadcrumb-item active">Order Detail</li>--}}
                    {{--</ol>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('invoice', $order_info->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-receipt"></i> Invoice
                    </a>
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2">
                                    <h5><b>Customer Info.</b></h5>
                                </th>
                                <th class="text-center" colspan="2">
                                    <h5><b>Shipment Info.</b></h5>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-right">
                                    Invoice
                                </th>
                                <td class="text-left">
                                    {{ $order_info->invoice_no }}
                                </td>
                                <th class="text-right">
                                    Contact Person
                                </th>
                                <td class="text-left">
                                    {{ $order_info->contact_person_name }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">
                                    Customer Name
                                </th>
                                <td class="text-left">
                                    {{ $customer_info[0]->full_name }}
                                </td>
                                <th class="text-right">
                                    Contact No
                                </th>
                                <td class="text-left">
                                    {{ $order_info->contact_person_contact_no }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">
                                    Email
                                </th>
                                <td class="text-left">
                                    {{ $customer_info[0]->email }}
                                </td>
                                <th class="text-right">
                                    Email
                                </th>
                                <td class="text-left">
                                    {{ $order_info->contact_person_email }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">
                                    Contact
                                </th>
                                <td class="text-left">
                                    {{ $customer_info[0]->contact_no }}
                                </td>
                                <th class="text-right">
                                    Address
                                </th>
                                <td class="text-left">
                                    {{ $order_info->contact_person_shipping_address }}
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    SL
                                </th>
                                <th class="text-center">
                                    Product Name
                                </th>
                                <th class="text-center">
                                    Color
                                </th>
                                <th class="text-center">
                                    Size
                                </th>
                                <th class="text-center">
                                    Quantity
                                </th>
                                <th class="text-center">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_detail as $k => $order)
                                <tr>
                                    <td class="text-center">
                                        {{ $k+1 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $order->product_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $order->color }}
                                    </td>
                                    <td class="text-center">
                                        {{ $order->size }}
                                    </td>
                                    <td class="text-center">
                                        {{ $order->quantity }}
                                    </td>
                                    <td class="text-center">
                                        {{ $order->price }}
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                {{--<div class="col-sm-12">--}}
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="2">
                                            <h5><b>Summary</b></h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Total Amount</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $order_info->total_amount }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Shipment Charge</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $order_info->shipment_charge }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>VAT({{ $company_info[0]->vat_percentage }}%)</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $order_info->vat_amount }} </span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Net Amount</b></th>
                                        <td class="text-left" width="50%"><span>৳ {{ $order_info->net_amount }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Payment Status</b></th>
                                        <td class="text-left" width="50%">
                                            {{ ($order_info->payment_type == 1 ? 'Cash on Delivery' : ($order_info->payment_type == 1 ? 'e-Payment' : '')) }}
                                            @if($order_info->payment_status == 1)
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($order_info->payment_status == 0)
                                                <span class="badge badge-danger">Not Paid</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Order Status</b></th>
                                        <td class="text-left" width="50%">
                                            @if($order_info->status == 0)
                                                CANCELLED
                                            @elseif($order_info->status == 1)
                                                RECEIVED
                                            @elseif($order_info->status == 2)
                                                CONFIRMED
                                            @elseif($order_info->status == 3)
                                                ON SHIPMENT
                                            @elseif($order_info->status == 4)
                                                DELIVERED
                                            @endif
                                        </td>
                                    </tr>
                                    @if($order_info->status == 1)
                                        <tr>
                                            <th class="text-right" width="50%">
                                                <a href="{{ route('order_cancel', $order_info->id) }}" class="btn btn-danger">CANCEL ORDER</a>
                                            </th>
                                            <td class="text-left" width="50%">
                                                <a href="{{ route('order_confirm', $order_info->id) }}" class="btn btn-primary">CONFIRM ORDER</a>
                                            </td>
                                        </tr>
                                    @endif
                                </thead>
                            </table>
                        </div>
                    </div>

                @if($order_info->status == 2)
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <form action="{{ route('shipment_confirm', $order_info->id) }}" method="post">

                                @method('PUT')
                                {{ csrf_field() }}

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="2">
                                                <h5><b>Shipment</b></h5>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="30%"><b>Shipment By</b> <span style="color: red;">*</span></th>
                                            <td class="text-left" width="70%">
                                                <input type="text" class="form-control" name="shipment_by" id="shipment_by" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="30%"><b>Shipment Remarks</b></th>
                                            <td class="text-left" width="70%">
                                                <input type="text" class="form-control" name="shipment_remarks" id="shipment_remarks">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right" width="30%"></th>
                                            <td class="text-left" width="70%">
                                                <button class="btn btn-primary">Confirm Shipment</button>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                @endif

                @if($order_info->status == 3 || $order_info->status == 4)
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="2">
                                            <h5><b>Shipment</b></h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Shipment By</b></th>
                                        <td class="text-left" width="50%">
                                            {{ $order_info->shipment_by }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" width="50%"><b>Shipment Remarks</b></th>
                                        <td class="text-left" width="50%">
                                            {{ $order_info->shipment_remarks }}
                                        </td>
                                    </tr>
                                    @if($order_info->status == 3)
                                        <tr>
                                            <th class="text-right" width="50%"></th>
                                            <td class="text-left" width="50%">
                                                <a href="{{ route('order_deliver', $order_info->id) }}" class="btn btn-primary">ORDER DELIVER</a>
                                            </td>
                                        </tr>
                                    @endif
                                </thead>
                            </table>
                        </div>
                    </div>
                @endif
                {{--</div>--}}
            </div>
        </div>
            <!-- /.card-body -->

        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection