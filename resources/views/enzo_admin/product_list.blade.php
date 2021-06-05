@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                <h3 class="card-title">
                    <a class="btn btn-success btn-sm" href="{{ route('product.create') }}">
                        <i class="fas fa-plus"></i>
                        Product
                    </a>
                </h3>

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
                <table class="table table-bordered projects">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th class="text-center">
                                Category
                            </th>
                            <th class="text-center">
                                Sub-Category
                            </th>
                            <th class="text-center">
                                Product Name
                            </th>
                            <th class="text-center">
                                Price(৳)
                            </th>
                            <th class="text-center">
                                Price($)
                            </th>
                            <th class="text-center">
                                Stock Qty
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
                        @foreach($product_list as $prod)
                            <tr>
                                <td class="text-center">
                                    {{ $prod->id }}
                                </td>
                                <td class="text-center">
                                    {{ $prod->category_name }}
                                </td>
                                <td class="text-center">
                                    {{ $prod->sub_category_name }}
                                </td>
                                <td class="text-center">
                                    {{ $prod->product_name }}
                                </td>
                                <td class="text-center">
                                    {{ $prod->price_in_bdt }}
                                </td>
                                <td class="text-center">
                                    {{ $prod->price_in_usd }}
                                </td>
                                <td class="text-center">
                                    {{ ($prod->total_stock_qty != '' ? $prod->total_stock_qty : 0) }}
                                </td>
                                <td class="text-center">
                                    @if($prod->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                    @if($prod->status == 0)
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-xs" href="{{ route('product.edit', $prod->id) }}" title="Edit" data-toggle="tooltip" data-placement="top">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-secondary btn-xs" href="{{ route('product_stock_management', $prod->id) }}" title="Stock" data-toggle="tooltip" data-placement="top">
                                        <i class="fas fa-warehouse"></i>
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