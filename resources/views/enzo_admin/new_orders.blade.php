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
            <div class="card-body p-0">
                <table class="table table-striped projects">
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
                    <tbody>
                        @foreach($new_orders as $new_order)
                            <tr>
                                <td class="text-center">
                                    {{ $new_order->id }}
                                </td>
                                <td class="text-center">
                                    {{ $new_order->invoice_no }}
                                </td>
                                <td class="text-center">
                                    {{ $new_order->net_amount }}
                                </td>
                                <td class="text-center">
                                    {{ ($new_order->payment_status == 1 ? 'PAID' : 'PENDING') }}
                                </td>
                                <td class="text-center">
                                    @if($new_order->status == 0)
                                        CANCELLED
                                    @elseif($new_order->status == 1)
                                        RECEIVED
                                    @elseif($new_order->status == 2)
                                        CONFIRMED
                                    @elseif($new_order->status == 3)
                                        ON SHIPMENT
                                    @elseif($new_order->status == 4)
                                        DELIVERED
                                    @endif
                                </td>
                                <td class="project-actions text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('new_order_detail', $new_order->id) }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection