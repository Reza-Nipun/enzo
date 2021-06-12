@extends('enzo_site.layout')

@section('content')

<!-- banner -->
<div class="" id="">
    <div class="container">

    </div>
</div>
<!-- //banner -->

<!-- mail -->
<div class="mail">
    <div class="container">
        <h3>Forgot Password</h3>
        <div class="register">

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            @if(Session::has('forgot_password_error_message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('forgot_password_error_message') }}</p>
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

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('change_customer_password') }}" method="post">

                    {{ csrf_field() }}

                    <input type="email" placeholder="Email Address" name="email" value="{{ $token->email }}" readonly="readonly">
                    <input type="password" placeholder="New Password" name="password">
                    <input type="password" placeholder="Confirm Password" name="confirmed_password">
                    <br />
                    <br />
                    <button class="btn btn-primary">Change Password</button>
                </form>
            </div>
            <div class="col-md-3"></div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>
<!-- //mail -->

@endsection