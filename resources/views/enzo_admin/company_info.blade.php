@extends('enzo_admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Company Info</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Company Info</li>
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">
                                Company Name
                            </th>
                            <th class="text-center">
                                Email
                            </th>
                            <th class="text-center">
                                Phone
                            </th>
                            <th class="text-center">
                                Fax
                            </th>
                            <th class="text-center">
                                Address
                            </th>
                            <th class="text-center">
                                Latitude
                            </th>
                            <th class="text-center">
                                Longitude
                            </th>
                            <th class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($company_info as $company)
                        <tr>
                            <td class="text-center">
                                {{ $company->company_name }}
                            </td>
                            <td class="text-center">
                                {{ $company->company_email }}
                            </td>
                            <td class="text-center">
                                {{ $company->company_phone }}
                            </td>
                            <td class="text-center">
                                {{ $company->company_fax }}
                            </td>
                            <td class="text-center">
                                {{ $company->company_full_address }}
                            </td>
                            <td class="text-center">
                                {{ $company->latitude }}
                            </td>
                            <td class="text-center">
                                {{ $company->longitude }}
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('company_info.edit', $company->id) }}">
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