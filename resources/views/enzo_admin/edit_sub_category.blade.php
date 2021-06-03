@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub-Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sub_category.index') }}">Sub-Category List</a></li>
                        <li class="breadcrumb-item active">Create Sub-Category</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <form action="{{ route('sub_category.update', $sub_category->id) }}" method="post">

        @method('PATCH')
        {{ csrf_field() }}

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Sub-Category Info</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputStatus">Category *</label>
                                    <select id="inputStatus" class="form-control custom-select" name="category">
                                        <option value="">Select Category</option>

                                        @foreach($category_list as $cat)
                                            <option value="{{ $cat->id }}" @if($sub_category->category_id == $cat->id) selected="selected" @endif>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputName">Sub-Category Name *</label>
                                    <input type="text" id="inputName" class="form-control" name="sub_category_name" value="{{ $sub_category->sub_category_name }}">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputDescription">Description</label>
                                    <input type="text" id="inputDescription" class="form-control" name="sub_category_description" value="{{ $sub_category->sub_category_description }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputStatus">Status *</label>
                                    <select id="inputStatus" class="form-control custom-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="1" @if($sub_category->status == 1) selected="selected" @endif>Active</option>
                                        <option value="0" @if($sub_category->status == 0) selected="selected" @endif>Inactive</option>
                                    </select>
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
            <div class="col-12">
                <a href="{{ route('sub_category.index') }}" class="btn btn-secondary" onclick="return confirm('Are you sure to cancel?')">Cancel</a>
                <button type="submit" class="btn btn-success float-right">UPDATE</button>
            </div>
        </div>
    </section>
    </form>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection