@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub-Category List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sub-Category List</li>
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
                    <a class="btn btn-success btn-sm" href="{{ route('sub_category.create') }}">
                        <i class="fas fa-plus"></i>
                        Sub-Category
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
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th class="text-center">
                                Category Name
                            </th>
                            <th class="text-center">
                                Sub-Category Name
                            </th>
                            <th class="text-center">
                                Description
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
                    @foreach($sub_category_list as $sub_cat)
                        <tr>
                            <td class="text-center">
                                {{ $sub_cat->id }}
                            </td>
                            <td class="text-center">
                                {{ $sub_cat->category_name }}
                            </td>
                            <td class="text-center">
                                {{ $sub_cat->sub_category_name }}
                            </td>
                            <td class="text-center">
                                {{ $sub_cat->sub_category_description }}
                            </td>
                            <td class="project-state">
                                @if($sub_cat->status == 1)
                                    <span class="badge badge-success">Active</span>
                                @endif
                                @if($sub_cat->status == 0)
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('sub_category.edit', $sub_cat->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
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