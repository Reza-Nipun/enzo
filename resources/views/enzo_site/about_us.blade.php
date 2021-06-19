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

    <!-- team -->
    {{--<div class="team">--}}
        {{--<div class="container">--}}
            {{--<h3>Meet Our Team</h3>--}}
            {{--<div class="wthree_team_grids">--}}
                {{--<div class="col-md-3 wthree_team_grid">--}}
                    {{--<img src="{{ asset('enzo_website_assets/images/8.png') }}" alt=" " class="img-responsive" />--}}
                    {{--<h4>Smith Allen <span>Fashion Designer</span></h4>--}}
                    {{--<div class="agileits_social_button">--}}
                        {{--<ul>--}}
                            {{--<li><a href="#" class="facebook"> </a></li>--}}
                            {{--<li><a href="#" class="twitter"> </a></li>--}}
                            {{--<li><a href="#" class="google"> </a></li>--}}
                            {{--<li><a href="#" class="pinterest"> </a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-3 wthree_team_grid">--}}
                    {{--<img src="{{ asset('enzo_website_assets/images/9.png') }}" alt=" " class="img-responsive" />--}}
                    {{--<h4>Laura James <span>Fashion Designer</span></h4>--}}
                    {{--<div class="agileits_social_button">--}}
                        {{--<ul>--}}
                            {{--<li><a href="#" class="facebook"> </a></li>--}}
                            {{--<li><a href="#" class="twitter"> </a></li>--}}
                            {{--<li><a href="#" class="google"> </a></li>--}}
                            {{--<li><a href="#" class="pinterest"> </a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-3 wthree_team_grid">--}}
                    {{--<img src="{{ asset('enzo_website_assets/images/10.png') }}" alt=" " class="img-responsive" />--}}
                    {{--<h4>Crisp Doe <span>Fashion Designer</span></h4>--}}
                    {{--<div class="agileits_social_button">--}}
                        {{--<ul>--}}
                            {{--<li><a href="#" class="facebook"> </a></li>--}}
                            {{--<li><a href="#" class="twitter"> </a></li>--}}
                            {{--<li><a href="#" class="google"> </a></li>--}}
                            {{--<li><a href="#" class="pinterest"> </a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-3 wthree_team_grid">--}}
                    {{--<img src="{{ asset('enzo_website_assets/images/11.png') }}" alt=" " class="img-responsive" />--}}
                    {{--<h4>Linda Rosy <span>Fashion Designer</span></h4>--}}
                    {{--<div class="agileits_social_button">--}}
                        {{--<ul>--}}
                            {{--<li><a href="#" class="facebook"> </a></li>--}}
                            {{--<li><a href="#" class="twitter"> </a></li>--}}
                            {{--<li><a href="#" class="google"> </a></li>--}}
                            {{--<li><a href="#" class="pinterest"> </a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="clearfix"> </div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!-- //team -->

@endsection