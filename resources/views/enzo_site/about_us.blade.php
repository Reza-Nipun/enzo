@extends('enzo_site.layout')

@section('content')
    <!-- banner -->
    <div class="" id="">
        <div class="container">

        </div>
    </div>
    <!-- //banner -->

    <!-- about -->
    <div class="mail">
        <div class="container">
            <h3>About Us</h3>
            <div class="w3ls_about_grids">
                <div class="col-md-12 w3ls_about_grid_left">
                    {!! $company_info[0]->about_us !!}
                    <div class="clearfix"> </div>
                </div>
                {{--<div class="col-md-6 w3ls_about_grid_right">--}}
                    {{--<img src="{{ asset('enzo_website_assets/images/77.jpg') }}" alt=" " class="About Us" />--}}
                {{--</div>--}}
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //about -->

@endsection