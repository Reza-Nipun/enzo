@extends('enzo_admin.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product List</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">

        @method('PATCH')
        {{ csrf_field() }}

        <section class="content">

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            @if(count($errors))
                <div class="form-group">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Product Info</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputCategory">Category <span style="color: red">*</span></label>
                                        <select id="inputCategory" class="form-control custom-select" name="category" onchange="getSubCategoryList()" required="required">
                                            <option value="">Select Category</option>
                                            @foreach($category_list as $cat)
                                                <option value="{{ $cat->id }}" @if($product->category_id == $cat->id) selected="selected" @endif>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSubCategory">Sub-Category <span style="color: red">*</span></label>
                                        <select id="inputSubCategory" class="form-control custom-select" name="sub_category" required="required">
                                            <option  value="">Select Sub-Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputProductName">Product Name <span style="color: red">*</span></label>
                                        <input type="text" id="inputProductName" class="form-control" name="product_name" autocomplete="off" required="required" value="{{ $product->product_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputProductCode">Product Code</label>
                                        <input type="text" id="inputProductCode" class="form-control" name="product_code" autocomplete="off" value="{{ $product->product_code }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputStatus">Status <span style="color: red">*</span></label>
                                        <select id="inputStatus" class="form-control custom-select" name="status" required="required">
                                            <option value="">Select Status</option>
                                            <option value="1" @if($product->status == 1) selected="selected" @endif>Active</option>
                                            <option value="0" @if($product->status == 0) selected="selected" @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputShortDescription">Short Description</label>

                                        <textarea id="summernote" placeholder="Short Description Here..." name="product_short_description">{{ $product->product_short_description }}</textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPriceBdt">Price(BDT) <span style="color: red">*</span></label>
                                        <input type="text" id="inputPriceBdt" class="form-control" name="price_in_bdt" value="{{ $product->price_in_bdt }}" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPriceUsd">Price(USD) <span style="color: red">*</span></label>
                                        <input type="text" id="inputPriceUsd" class="form-control" name="price_in_usd" value="{{ $product->price_in_usd }}" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputMetaKeywords">Meta Keywords</label>
                                        <input type="text" id="inputMetaKeywords" class="form-control" name="meta_keywords" value="{{ $product->meta_keywords }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputMetaDescription">Meta Description</label>
                                        <textarea id="inputMetaDescription" class="form-control" rows="2" name="meta_description">{{ $product->meta_description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Color</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="color_table">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="25%">Color <span style="color: red">*</span></th>
                                        <th class="text-center" width="20%">Color Code <span style="color: red">*</span></th>
                                        <th class="text-center" width="40%">
                                            Images(Multiple Allowed) <span style="color: red">*</span>
                                        </th>
                                        <th width="15%">
                                            <span class="btn btn-xs btn-success" onclick="addNewColor()">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="btn btn-xs btn-danger" id="DeleteButton">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($product_colors as $k => $product_color)
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" id="" class="form-control" name="color_name_old[]" required="required" autocomplete="off" value="{{ $product_color->color }}" rea>
                                            <input type="hidden" id="" class="form-control" name="color_ids[]" required="required" autocomplete="off" value="{{ $product_color->id }}" readonly="readonly">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control my-colorpicker1" name="color_code_old[]" required="required" autocomplete="off" value="{{ $product_color->color_code }}">
                                        </td>
                                        <td class="text-center">
                                            <input type="file" class="form-control" id="file" multiple="multiple" name="file_old_{{ $k }}[]" onchange="return fileValidation()" accept="image/png, image/jpeg, image/jpg">
                                            <span class="btn btn-xs btn-warning" title="View Images" onclick="getExistingImages('{{ $product->id }}', '{{ $product_color->id }}');">
                                                View Images: <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <select name="old_colors_status[]" required="required">
                                                <option value="">Status</option>
                                                <option value="1" @if($product_color->status == 1) selected="selected" @endif>Active</option>
                                                <option value="0" @if($product_color->status == 0) selected="selected" @endif>Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Size</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="size_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Size <span style="color: red">*</span></th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">
                                            <span class="btn btn-sm btn-success" onclick="addNewSize()">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_sizes as $size)
                                        <tr>
                                            <td class="text-center">
                                                <input type="text" id="" class="form-control" name="sizes_old[]" required="required" autocomplete="off" value="{{ $size->size }}">
                                                <input type="hidden" id="" class="form-control" name="size_ids[]" required="required" autocomplete="off" value="{{ $size->id }}" readonly="readonly">
                                            </td>
                                            <td class="text-center">
                                                <input type="text" id="" class="form-control" name="size_descriptions_old[]" autocomplete="off" value="{{ $size->size_description }}">
                                            </td>
                                            <td class="text-center">
                                                <select name="old_sizes_status[]" required="required">
                                                    <option value="">Status</option>
                                                    <option value="1" @if($size->status == 1) selected="selected" @endif>Active</option>
                                                    <option value="0" @if($size->status == 0) selected="selected" @endif>Inactive</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Specifications</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="specification_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Title <span style="color: red">*</span></th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">
                                            <span class="btn btn-sm btn-success" onclick="addNewSpecification()">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($product_specifications as $product_specification)
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" id="" class="form-control" name="specification_name_old[]" required="required" autocomplete="off" value="{{ $product_specification->specification_name }}">
                                            <input type="hidden" id="" class="form-control" name="specification_id_old[]" required="required" autocomplete="off" value="{{ $product_specification->id }}" readonly="readonly">
                                        </td>
                                        <td class="text-center">
                                            <textarea id="inputDescription" class="form-control" rows="2" name="specification_description_old[]">{{ $product_specification->specification_description }}</textarea>
                                        </td>
                                        <td class="text-center">
                                            <select name="old_specifications_status[]" required="required">
                                                <option value="">Status</option>
                                                <option value="1" @if($product_specification->status == 1) selected="selected" @endif>Active</option>
                                                <option value="0" @if($product_specification->status == 0) selected="selected" @endif>Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary" onclick="return confirm('Are you sure to cancel?')">Cancel</a>
                    <button type="submit" class="btn btn-success float-right">Update Product</button>
                </div>
            </div>
        </section>
    </form>
    <!-- /.content -->

    <!-- /.modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Product Images</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="existing_images">
                            <tr>
                                <td class="text-center">
                                    <div class="col-auto">
                                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-danger" id="DeleteImage">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-default" data-dismiss="modal">Close</span>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</div>
<!-- /.content-wrapper -->

<script type="text/javascript">

    $( document ).ready(function() {
        getSubCategoryList();
    });

    function getExistingImages(product_id, color_id) {

        $("#existing_images").empty();

        $.ajax({
            url: "{{ url("get_existing_images") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", product_id: product_id, color_id: color_id},
            dataType: "json",
            success: function (data) {

                for(var i=0; i < data.length; i++){

                    var image_id = data[i].id;
                    var image_url = data[i].image_url;

                    $("#existing_images").append('<tr><td class="text-center"><div class="col-auto"><span class="preview"><img src="{{ asset('storage/app/public/uploads/') }}/'+image_url+'" alt="" data-dz-thumbnail width="100" height="100" /></span></div></td><td class="text-center"><span class="btn btn-sm btn-danger" id="DeleteImage" onclick="deleteImage('+image_id+', '+product_id+', '+color_id+')"><i class="fas fa-trash"></i></span></td></tr>');
                }

                $('#modal-default').modal('show');

            }
        });


    }

    function deleteImage(image_id, product_id, color_id) {

        var res = confirm('Are you sure to delete the image?');

        if(res == true){
            $.ajax({
                url: "{{ url("delete_existing_image") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", image_id: image_id},
                dataType: "json",
                success: function (data) {

                    getExistingImages(product_id, color_id);

                }
            });
        }

    }

    function getSubCategoryList() {
        var category = $("#inputCategory").val();
        var selected = '';

        $("#inputSubCategory").empty();

        $.ajax({
            url: "{{ url("get_sub_category_list_by_cat_id") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", category: category},
            dataType: "json",
            success: function (data) {

                $("#inputSubCategory").append('<option  value="">Select Sub-Category</option>');

                for(var i=0; i < data.length; i++){

                    if('<?php echo $product->sub_category_id;?>' == data[i].id){
                        selected = 'selected="selected"';
                    }

                    $("#inputSubCategory").append('<option  value="'+data[i].id+'" '+selected+'>'+data[i].sub_category_name+'</option>');
                }

            }
        });
    }

    function addNewColor(){
        var rowCount = $("#color_table > tbody").children(".new_color").length;

        $("#color_table > tbody").append('<tr class="new_color"><td class="text-center"><input type="text" id="" class="form-control" name="color_name[]" required="required" autocomplete="off"></td><td class="text-center"><input type="text" class="form-control my-colorpicker1" name="color_code[]" required="required" autocomplete="off"></td><td class="text-center"><input type="file" class="form-control" id="file" multiple="multiple" name="file_'+rowCount+'[]" required="required" accept="image/png, image/jpeg, image/jpg"></td><td class="text-center"></td></tr>');
        $('.my-colorpicker1').colorpicker();
    }

    var $tbody = $("#color_table tbody")
    $("#DeleteButton").click(function (){
        var $last = $tbody.find('tr.new_color:last');
//        if($last.is(':first-child')){
//            alert('last is the only one')
//        }else {
            $last.remove()
//        }
    });
    
    function addNewSize() {
        $("#size_table > tbody").append('<tr><td><input type="text" id="" class="form-control" name="sizes[]" required="required" autocomplete="off"></td><td class=""><input type="text" id="" class="form-control" name="size_descriptions[]" autocomplete="off"></td><td><span class="btn btn-sm btn-danger" id="DeleteSizeButton"><i class="fas fa-trash"></i></span></td></tr>');
    }

    $("#size_table").on("click", "#DeleteSizeButton", function() {
        $(this).closest("tr").remove();
    });

    function addNewSpecification() {
        $("#specification_table > tbody").append('<tr><td><input type="text" id="" class="form-control" name="specification_name[]" required="required" autocomplete="off"></td><td class="text-center"><textarea id="inputDescription" class="form-control" rows="2" name="specification_description[]"></textarea></td><td class="text-center"><span class="btn btn-sm btn-danger" id="DeleteSpecificationButton"><i class="fas fa-trash"></i></span></td></tr>');
    }

    $("#specification_table").on("click", "#DeleteSpecificationButton", function() {
        $(this).closest("tr").remove();
    });

    function fileValidation() {
        var fileInput = document.getElementById('file');

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /(\.jpg|\.jpeg|\.png)$/i;

        if (!allowedExtensions.exec(filePath)) {
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        }
        if (!fileInput.files[0].name.match(/.(jpg|jpeg|png)$/i))
            alert('not an image');
    }

</script>    
    
@endsection