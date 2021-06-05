@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Stock</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product List</a></li>
                        <li class="breadcrumb-item active">Product Stock</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Product
                                    </th>
                                    <td class="text-center">
                                        {{ $product->product_name }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-xs" href="{{ route('product.edit', $product->id) }}" title="Edit" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-pencil-alt"></i> Edit Product
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center">
                                        Total Stock Quantity
                                    </th>
                                    <td class="text-center">
                                        @php
                                            $total_stock_qty = 0;
                                        @endphp

                                        @foreach($product_stocks as $product_stock)
                                            @php
                                                $total_stock_qty += $product_stock->quantity;
                                            @endphp
                                        @endforeach

                                        {{ $total_stock_qty }}
                                    </td>
                                    <td class="text-center">

                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->

        <form action="{{ route('update_product_stock') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <span class="btn btn-primary btn-sm" onclick="createColorSizeCombination('{{ $product->id }}')">
                        <i class="fas fa-plus"></i>
                        Color-Size Combination
                    </span>
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
                                Color
                            </th>
                            <th class="text-center">
                                Size
                            </th>
                            <th class="text-center">
                                Stock Quantity
                            </th>
                            <th class="text-center">
                                Order in Line
                            </th>
                            <th class="text-center">
                                Balance
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($product_stocks as $product_stock)
                        <tr>
                            <td class="text-center">
                                {{ $product_stock->color }}

                                @if($product_stock->color_status == 0)
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $product_stock->size.' - '.$product_stock->size_description }}

                                @if($product_stock->size_status == 0)
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td align="center">
                                <input type="hidden" class="form-control" name="product_stock_id[]" value="{{ $product_stock->id }}" required="required" style="width: 100px;" autocomplete="off" readonly="readonly">
                                <input type="number" class="form-control" name="product_stock_quantity[]" value="{{ $product_stock->quantity }}" required="required" style="width: 100px;" autocomplete="off">
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="row mb-2">
            <div class="col-12">
                <a href="{{ route('product.index') }}" class="btn btn-secondary" onclick="return confirm('Are you sure to cancel?')">Cancel</a>
                <button type="submit" class="btn btn-success float-right">UPDATE STOCK</button>
            </div>
        </div>

        </form>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- /.modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Color-Size Combination</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control custom-select" name="color" id="color_id">
                                <option value="">Select Color</option>
                                @foreach($product_colors as $product_color)
                                    <option value="{{ $product_color->id }}">{{ $product_color->color }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control custom-select" name="size" id="size_id">
                                <option value="">Select Size</option>
                                @foreach($product_sizes as $product_size)
                                    <option value="{{ $product_size->id }}">{{ $product_size->size.' - '.$product_size->size_description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <span type="button" class="btn btn-default" data-dismiss="modal">Close</span>
                <span type="button" class="btn btn-primary" onclick="saveNewColorSizeCombination('{{ $product->id }}')">Save</span>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

<script type="text/javascript">

    function createColorSizeCombination(product_id) {

        $('#modal-default').modal('show');

    }

    function saveNewColorSizeCombination(product_id) {

        var color = $("#color_id").val();
        var size = $("#size_id").val();

        if(color != '' && size != ''){

            $.ajax({
            url: "{{ route("save_new_color_size_combination") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", product_id: product_id, color_id: color, size_id: size},
            dataType: "json",
            success: function (data) {

                if(data.length > 0){
                    alert('Selected Color-Size Combination is already exist!');
                }else{
                    location.reload();
                }

            }

            });

        }else{
            alert('Please select required fields');
        }

    }

</script>