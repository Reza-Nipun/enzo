@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="invoice_no_filter">Invoice#</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="invoice_no_filter" id="invoice_no_filter">
                                    <option value="">Select Invoice</option>
                                    @foreach($all_orders as $order_no)
                                        <option value="{{ $order_no->id }}">{{ $order_no->invoice_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="order_status_filter">Order Status</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="order_status_filter" id="order_status_filter">
                                    <option value="">Select Status</option>
                                    <option value="0">Cancelled</option>
                                    <option value="1">Received</option>
                                    <option value="2">Processing</option>
                                    <option value="3">On-Shipment</option>
                                    <option value="4">Delivered</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Order Date Range <span class="badge badge-danger" onclick="return $('#order_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control float-right reservationtime" id="order_date_range_filter">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer_filter">Customer</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="customer_filter" id="customer_filter">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nick_name.' - '.$customer->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="search_btn"><span style="color: #ffffff;">.</span></label>
                                <button class="form-control btn btn-primary" id="search_btn" onclick="searchOrder()">SEARCH</button>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-1">
                            <label for=""><span style="color: #ffffff;">.</span></label>
                            <div class="loader" style="display: none;"></div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th class="text-center">
                                Invoice
                            </th>
                            <th class="text-center">
                                Net Amount
                            </th>
                            <th class="text-center">
                                Payment Status
                            </th>
                            <th class="text-center">
                                Status
                            </th>
                            <th class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tbody_id">
                        @foreach($orders as $k => $new_order)
                            <tr>
                                <td class="text-center">
                                    {{ $k+1 }}
                                </td>
                                <td class="text-center">
                                    {{ $new_order->invoice_no }}
                                </td>
                                <td class="text-center">
                                    {{ $new_order->net_amount }}
                                </td>
                                <td class="text-center">
                                    @if($new_order->payment_type == 1)
                                        Cash-on-Delivery
                                    @elseif($new_order->payment_type == 2)
                                        e-Payment
                                    @endif

                                    @if($new_order->payment_status == 0)
                                        <span class="badge badge-danger">Not Paid</span>
                                    @elseif($new_order->payment_status == 1)
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($new_order->status == 0)
                                        <span class="badge badge-danger">CANCELLED</span>
                                    @elseif($new_order->status == 1)
                                        <span class="badge badge-info">RECEIVED</span>
                                    @elseif($new_order->status == 2)
                                        <span class="badge badge-primary">CONFIRMED</span>
                                    @elseif($new_order->status == 3)
                                        <span class="badge badge-warning">ON-SHIPMENT</span>
                                    @elseif($new_order->status == 4)
                                        <span class="badge badge-success">DELIVERED</span>
                                    @endif
                                </td>
                                <td class="project-actions text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('new_order_detail', $new_order->id) }}">
                                        <i class="fas fa-tasks"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="align-items-center d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">


    function searchOrder() {
        var invoice_no = $("#invoice_no_filter").val();
        var order_status = $("#order_status_filter").val();
        var customer = $("#customer_filter").val();

//        Order Date Range Start
        var order_dt_range_filter = $("#order_date_range_filter").val();
        var order_date_range_filter = order_dt_range_filter.split(" - ");

        var order_date_from = order_date_range_filter[0];
        var order_date_to = (order_date_range_filter[1] != undefined ? order_date_range_filter[1] : '');
//        Order Date Range End

        $(".loader").css('display', 'block');
        $("#tbody_id").empty();

        $.ajax({
            url: "{{ route("search_order") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", invoice_no: invoice_no, order_status: order_status, customer: customer, order_date_from: order_date_from, order_date_to: order_date_to},
            dataType: "html",
            success: function (data) {
                $("#tbody_id").append(data);
                $(".loader").css('display', 'none');
            }
        });
//        }

    }

</script>

@endsection