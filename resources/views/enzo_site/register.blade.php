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
        <h3>Register</h3>
        <div class="register">

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

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('customer.store') }}" method="post">

                    {{ csrf_field() }}

                    <input placeholder="Nick Name" name="nick_name" type="text" required="required" value="{{ old('nick_name') }}">
                    <input placeholder="Your Full Name" name="full_name" type="text" required="required" value="{{ old('full_name') }}">
                    <input placeholder="Email Address" name="email" type="email" required="required" value="{{ old('email') }}">
                    <input placeholder="Contact No" name="contact_no" type="text" required="required" value="{{ old('contact_no') }}">
                    <input placeholder="Your Address" name="address" type="text" required="required" value="{{ old('address') }}">
                    <input placeholder="Password" name="password" type="password" required="required">
                    <input placeholder="Confirm Password" name="confirmed_password" type="password" required="required">
                    <input type="submit" value="Create Account" >
                </form>
            </div>
            <div class="col-md-3"></div>
            <div class="clearfix"> </div>
        </div>

    </div>
</div>
<!-- //mail -->

@endsection