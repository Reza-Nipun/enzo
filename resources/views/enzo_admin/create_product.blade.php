@extends('enzo_admin.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product List</a></li>
                        <li class="breadcrumb-item active">Create Product</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">

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
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                                        <input type="text" id="inputProductName" class="form-control" name="product_name" autocomplete="off" required="required" value="{{old('product_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputProductCode">Product Code</label>
                                        <input type="text" id="inputProductCode" class="form-control" name="product_code" autocomplete="off" value="{{old('product_code')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputStatus">Status <span style="color: red">*</span></label>
                                        <select id="inputStatus" class="form-control custom-select" name="status" required="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputShortDescription">Short Description</label>

                                        <textarea class="form-control" id="summernote" placeholder="Short Description Here..." name="product_short_description">{{old('product_short_description')}}</textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPriceBdt">Price(BDT) <span style="color: red">*</span></label>
                                        <input type="text" id="inputPriceBdt" class="form-control" name="price_in_bdt" value="0" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPriceUsd">Price(USD) <span style="color: red">*</span></label>
                                        <input type="text" id="inputPriceUsd" class="form-control" name="price_in_usd" value="0" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputMetaKeywords">Meta Keywords</label>
                                        <input type="text" id="inputMetaKeywords" class="form-control" name="meta_keywords" value="{{old('meta_keywords')}}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputMetaDescription">Meta Description</label>
                                        <textarea id="inputMetaDescription" class="form-control" rows="2" name="meta_description">{{old('meta_description')}}</textarea>
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
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" id="" class="form-control" name="color_name[]" required="required" autocomplete="off">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control my-colorpicker1" name="color_code[]" required="required" autocomplete="off">
                                        </td>
                                        <td class="text-center">
                                            <input type="file" class="form-control" id="file" multiple="multiple" name="file_0[]" required="required" onchange="return fileValidation()" accept="image/png, image/jpeg, image/jpg">
                                        </td>
                                        <td class="text-center">

                                        </td>
                                    </tr>
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
                                <tr>
                                    <td class="text-center">
                                        <input type="text" id="" class="form-control" name="sizes[]" required="required" autocomplete="off">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" id="" class="form-control" name="size_descriptions[]" autocomplete="off">
                                    </td>
                                    <td class="text-center">
                                        <span class="btn btn-sm btn-danger" id="DeleteSizeButton">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </td>
                                </tr>
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
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" id="" class="form-control" name="specification_name[]" required="required" autocomplete="off">
                                        </td>
                                        <td class="text-center">
                                            <textarea id="inputDescription" class="form-control" rows="2" name="specification_description[]"></textarea>
                                        </td>
                                        <td class="text-center">
                                            <span class="btn btn-sm btn-danger" id="DeleteSpecificationButton">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </td>
                                    </tr>
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
                    <button type="submit" class="btn btn-success float-right">Create Product</button>
                </div>
            </div>
        </section>
    </form>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">

    function getSubCategoryList() {
        var category = $("#inputCategory").val();

        $("#inputSubCategory").empty();

        $.ajax({
            url: "{{ url("get_sub_category_list_by_cat_id") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", category: category},
            dataType: "json",
            success: function (data) {

                $("#inputSubCategory").append('<option  value="">Select Sub-Category</option>');

                for(var i=0; i < data.length; i++){
                    $("#inputSubCategory").append('<option  value="'+data[i].id+'">'+data[i].sub_category_name+'</option>');
                }

            }
        });
    }

    function addNewColor(){
        var rowCount = $("#color_table > tbody").children().length;

        $("#color_table > tbody").append('<tr><td class="text-center"><input type="text" id="" class="form-control" name="color_name[]" required="required" autocomplete="off"></td><td class="text-center"><input type="text" class="form-control my-colorpicker1" name="color_code[]" required="required" autocomplete="off"></td><td class="text-center"><input type="file" class="form-control" id="file" multiple="multiple" name="file_'+rowCount+'[]" required="required" accept="image/png, image/jpeg, image/jpg"></td><td class="text-center"></td></tr>');
        $('.my-colorpicker1').colorpicker();
    }

    var $tbody = $("#color_table tbody")
    $("#DeleteButton").click(function (){
        var $last = $tbody.find('tr:last');
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