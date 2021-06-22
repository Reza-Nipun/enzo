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

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control select2bs4" style="width: 100%;" id="product">
                                <option value="">Product</option>

                                @foreach($product_list as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control select2bs4" style="width: 100%;" id="category" onchange="getSubCategoryList()">
                                <option value="">Category</option>
                                @foreach($category_list as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control select2bs4" style="width: 100%;" id="sub_category">
                                <option value="">Sub-Category</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <span class="btn btn-primary" onclick="filterProduct()">SEARCH</span>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>

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
                    <tbody id="product_list">
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

<script type="text/javascript">
    
    function filterProduct() {
        var product = $("#product").val();
        var category = $("#category").val();
        var sub_category = $("#sub_category").val();

        $.ajax({
            url: "{{ url("filter_product") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", product: product, category: category, sub_category: sub_category},
            dataType: "html",
            success: function (data) {

                $("#product_list").empty();
                $("#product_list").append(data);

            }
        });
    }
    
    function getSubCategoryList() {
        var category = $("#category").val();

        $("#sub_category").empty();

        $.ajax({
            url: "{{ url("get_sub_category_list_by_cat_id") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", category: category},
            dataType: "json",
            success: function (data) {

                $("#sub_category").append('<option  value="">Sub-Category</option>');

                for(var i=0; i < data.length; i++){
                    $("#sub_category").append('<option  value="'+data[i].id+'">'+data[i].sub_category_name+'</option>');
                }

            }
        });

    }
    
</script>
    
@endsection