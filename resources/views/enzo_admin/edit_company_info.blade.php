@extends('enzo_admin.layout')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Company Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('company_info.index') }}">Company Info</a></li>
                            <li class="breadcrumb-item active">Edit Company Info</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <form action="{{ route('company_info.update', $company->id) }}" method="post" enctype="multipart/form-data">

            @method('PATCH')

            {{ csrf_field() }}

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Category Info</h3>

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
                                            <label for="inputName">Company Name </label>
                                            <input type="text" id="inputName" class="form-control" name="company_name" value="{{ $company->company_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputDescription">Company Description </label>
                                            <textarea id="inputDescription" class="form-control" name="company_description">{{ $company->company_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputEmail">Email</label>
                                            <input type="email" id="inputEmail" class="form-control" name="company_email" value="{{ $company->company_email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputPhone">Phone</label>
                                            <input type="text" id="inputPhone" class="form-control" name="company_phone" value="{{ $company->company_phone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputFax">Fax</label>
                                            <input type="text" id="inputFax" class="form-control" name="company_fax" value="{{ $company->company_fax }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputAddress">Address</label>
                                            <input type="text" id="inputAddress" class="form-control" name="company_full_address" value="{{ $company->company_full_address }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputLogo">Logo</label>
                                            <input type="file" id="inputLogo" class="form-control" name="file">
                                            @if($company->company_logo != '')
                                                <a class="btn btn-xs btn-warning" title="View Images" href="{{ asset('storage/uploads/'.$company->company_logo) }}" target="_blank">
                                                    View Images: <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            <input type="hidden" class="form-control" name="previous_logo" readonly="readonly" value="{{ $company->company_logo }}">
                                        </div>
                                    </div>

                                </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="inputLatitude">Latitude</label>
                                                <input type="text" id="inputLatitude" class="form-control" name="latitude" value="{{ $company->latitude }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="inputLongitude">Longitude</label>
                                                <input type="text" id="inputLongitude" class="form-control" name="longitude" value="{{ $company->longitude }}">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <a href="{{ route('company_info.index') }}" class="btn btn-secondary" onclick="return confirm('Are you sure to cancel?')">Cancel</a>
                        <button type="submit" class="btn btn-success float-right">UPDATE</button>
                    </div>
                </div>
            </section>
        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection