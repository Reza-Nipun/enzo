<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
    <title>{{ isset($title) ? $title : 'ENZO' }}</title>
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Women's Fashion Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //for-mobile-apps -->
    <link href="{{ asset('enzo_website_assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('enzo_website_assets/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('enzo_website_assets/css/fasthover.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- js -->
    <script src="{{ asset('enzo_website_assets/js/jquery.min.js') }}"></script>
    <!-- //js -->
    <!-- countdown -->
    <link rel="stylesheet" href="{{ asset('enzo_website_assets/css/jquery.countdown.css') }}" />
    <!-- //countdown -->
    <!-- cart -->
    <script src="{{ asset('enzo_website_assets/js/simpleCart.min.js') }}"></script>
    <!-- cart -->
    <!-- for bootstrap working -->
    <script type="text/javascript" src="{{ asset('enzo_website_assets/js/bootstrap-3.1.1.min.js') }}"></script>
    <!-- //for bootstrap working -->
    <link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!-- start-smooth-scrolling -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->

    <link href="{{ asset('enzo_website_assets/fontawesome-free-5.15.3-web/css/all.css') }}" rel="stylesheet">

    <!-- favicon start -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('enzo_website_assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('enzo_website_assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('enzo_website_assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('enzo_website_assets/images/favicon/site.webmanifest') }}">
    <!-- favicon end -->

    <!-- Rating Pluging Start -->
    <link href="{{ asset('rating_plugin_assets/css/star-rating.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('rating_plugin_assets/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <!--suppress JSUnresolvedLibraryURL -->
    <script src="{{ asset('rating_plugin_assets/js/star-rating.js') }}" type="text/javascript"></script>
    <!-- Rating Pluging End -->
</head>

<body>
<!-- header -->
<div class="modal fade" id="myModal88" tabindex="-1" role="dialog" aria-labelledby="myModal88"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    Don't Wait, Login now!</h4>
            </div>
            <div class="modal-body modal-body-sub">
                <div class="row">
                    <div class="col-md-8 modal_body_left modal_body_left1">
                        <div class="sap_tabs">
                            <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                                <div class="facts">

                                    @if(Session::has('error_message'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error_message') }}</p>
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

                                    <div class="register">
                                        <form action="{{ route('customer_login') }}" method="post">

                                            {{ csrf_field() }}

                                            <input type="text" name="email" placeholder="Email Address" required="required" value="{{ old('email') }}">
                                            <input type="password" name="password" placeholder="Password" required="required">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success">SIGN IN</button>
                                                    <a href="{{ route('customer.create') }}" class="btn btn-primary">CREATE ACCOUNT</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="{{ route('customer_forgot_password') }}">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="{{ asset('enzo_website_assets/js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#horizontalTab').easyResponsiveTabs({
                                    type: 'default', //Types: default, vertical, accordion
                                    width: 'auto', //auto or any width like 600px
                                    fit: true   // 100% fit in a container
                                });
                            });
                        </script>
                        {{--<div id="OR" class="hidden-xs">--}}
                            {{--OR--}}
                        {{--</div>--}}
                    </div>
                    {{--<div class="col-md-4 modal_body_right modal_body_right1">--}}
                        {{--<div class="row text-center sign-with">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<h3 class="other-nw">--}}
                                    {{--Sign in with</h3>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-12">--}}
                                {{--<ul class="social">--}}
                                    {{--<li class="social_facebook"><a href="#" class="entypo-facebook"></a></li>--}}
                                    {{--<li class="social_dribbble"><a href="#" class="entypo-dribbble"></a></li>--}}
                                    {{--<li class="social_twitter"><a href="#" class="entypo-twitter"></a></li>--}}
                                    {{--<li class="social_behance"><a href="#" class="entypo-behance"></a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //		$('#myModal88').modal('show');
</script>
<div class="header" id="">
    {{--<div class="w3l_login">--}}
        {{--<a href="javaScript:void(0)" data-toggle="modal" data-target="#myModal88"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> Sign In</a--}}
    {{--</div>--}}
    <div class="container">

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <a href="{{ route('index') }}"><img src="{{ asset('storage/uploads/'.$company_info[0]->company_logo) }}" alt="ENZO" class="img-responsive center-block" width="200" height="100"></a>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <!--			<div class="search">-->
        <!--				<input class="search_box" type="checkbox" id="search_box">-->
        <!--				<label class="icon-search" for="search_box"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></label>-->
        <!--				<div class="search_form">-->
        <!--					<form action="#" method="post">-->
        <!--						<input type="text" name="Search" placeholder="Search...">-->
        <!--						<input type="submit" value="Send">-->
        <!--					</form>-->
        <!--				</div>-->
        <!--			</div>-->

        {{--<div class="cart box_1">--}}
            {{--<a href="checkout.php">--}}
                {{--<div class="total">--}}
                    {{--<span class="simpleCart_total"></span> (<span id="simpleCart_quantity" class="simpleCart_quantity"></span> items)</div>--}}
                {{--<img src="{{ asset('enzo_website_assets/images/bag.png') }}" alt="" />--}}
            {{--</a>--}}
            {{--<p><a href="javascript:;" class="simpleCart_empty">Empty Cart</a></p>--}}
            {{--<div class="clearfix"> </div>--}}
        {{--</div>--}}
        <div class="clearfix"> </div>
    </div>
</div>
<div class="navigation">
    <div class="container">
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header nav_2">
                <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                <ul class="nav navbar-nav">
                    <li class="active" id="home1"><a href="{{ route('index') }}" class="act">Home</a></li>
                    <!-- Mega Menu -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                        <ul class="dropdown-menu multi-column columns-3">
                            <div class="row">

                                @foreach($category_list as $category)
                                    @if($category->status == 1)
                                        @if($category->has('subcategories'))
                                        <div class="col-sm-6">
                                            <ul class="multi-column-dropdown">
                                                <h6>{{ $category->name }}</h6>

                                                @foreach($category->subcategories as $subcategory)

                                                    @if($subcategory->status == 1)
                                                        <li><a href="{{ route('product_list', $subcategory->id) }}">{{$subcategory->sub_category_name}}</a></li>
                                                    @endif

                                                @endforeach

                                            </ul>
                                        </div>
                                        @else
                                            <ul class="multi-column-dropdown">
                                                <h6>{{ $category->name }}</h6>
                                            </ul>
                                        @endif
                                    @endif
                                @endforeach

                                <div class="clearfix"></div>
                            </div>
                        </ul>
                    </li>
                    <li><a href="{{ route('about_us') }}">About-Us</a></li>
                    <li><a href="{{ route('contact_us') }}">Contact</a></li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <div class="row">

                                <div class="col-sm-8">
                                    <ul class="multi-column-dropdown">

                                        @if(!empty($customer_data['customer_id']))
                                            <li><a href="{{ route('customer.show', $customer_data['customer_id']) }}" style="margin-left: 5px">My Profile</a></li>
                                            <div class="clearfix"></div>
                                            <li><a href="{{ route('my_orders') }}" style="margin-left: 5px">Order History</a></li>
                                            <div class="clearfix"></div>
                                            <li><a href="{{ route('customer_logout') }}" style="margin-left: 5px">Logout</a></li>

                                        @else
                                            <li><a href="javaScript:void(0)" data-toggle="modal" data-target="#myModal88" style="margin-left: 5px">Sign In</a></li>
                                            <div class="clearfix"></div>
                                            <li><a href="{{ route('customer.create') }}" style="margin-left: 5px">Register</a></li>
                                        @endif
                                    </ul>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                        </ul>
                    </li>
                    <li>
                        <div class="cart box_1">
                            <a href="{{ route('get_cart_list') }}">
                                <div class="total">
                                    {{--<span class="simpleCart_total"></span> --}}
                                    <span id="simpleCart_quantity" class="">{{ $count_cart_items }}</span> items</div>
                                <img src="{{ asset('enzo_website_assets/images/bag.png') }}" alt="" />
                            </a>
                            {{--<p><a href="javascript:;" class="simpleCart_empty">Empty Cart</a></p>--}}
                            <div class="clearfix"> </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- //header -->


    @yield('content')


<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="w3_footer_grids">
            <div class="col-md-4 w3_footer_grid">
                <h3>Contact Info</h3>

                @if($company_info[0]->company_name != '')
                    <h4>{{ $company_info[0]->company_name }}</h4>
                @endif

                @if($company_info[0]->company_description != '')
                    <p>{{ $company_info[0]->company_description }}</p>
                @endif

                <ul class="address">

                    @if($company_info[0]->company_full_address != '')
                        <li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>{{ $company_info[0]->company_full_address }}</li>
                    @endif

                    @if($company_info[0]->company_email != '')
                        <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:{{ $company_info[0]->company_email }}">{{ $company_info[0]->company_email }}</a></li>
                    @endif

                    @if($company_info[0]->company_phone != '')
                        <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>{{ $company_info[0]->company_phone }}</li>
                    @endif
                </ul>
            </div>
            <div class="col-md-4 w3_footer_grid">
                <h3>Information</h3>
                <ul class="info">
                    <li><a href="{{ route('about_us') }}">About</a></li>
                    <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                    {{--<li><a href="short-codes.php">Short Codes</a></li>--}}
                    <li><a href="faq.php">FAQ's</a></li>
                    {{--<li><a href="products.php">Special Products</a></li>--}}
                </ul>
            </div>
            {{--<div class="col-md-3 w3_footer_grid">--}}
                {{--<h3>Category</h3>--}}
                {{--<ul class="info">--}}
                    {{--<li><a href="dresses.php">Dresses</a></li>--}}
                    {{--<li><a href="sweaters.php">Sweaters</a></li>--}}
                    {{--<li><a href="shirts.php">Shirts</a></li>--}}
                    {{--<li><a href="sarees.php">Sarees</a></li>--}}
                    {{--<li><a href="skirts.php">Shorts & Skirts</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <div class="col-md-4 w3_footer_grid">
                <h3>Profile</h3>
                <ul class="info">

                    @if(!empty($customer_data['customer_id']))
                        <li><a href="{{ route('customer.show', $customer_data['customer_id']) }}">My Profile</a></li>
                        <li><a href="{{ route('my_orders') }}">Order History</a></li>
                    @endif

                    <li><a href="{{ route('get_cart_list') }}">My Cart</a></li>
                </ul>
                <h4>Follow Us</h4>
                <div class="agileits_social_button">
                    <ul>
                        <li><a href="#" class="facebook"> </a></li>
                        <li><a href="#" class="twitter"> </a></li>
                        <li><a href="#" class="google"> </a></li>
                        <li><a href="#" class="pinterest"> </a></li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="footer-copy">
        <div class="footer-copy1">
            <div class="footer-copy-pos">
                <a href="#home1" class="scroll"><img src="{{ asset('enzo_website_assets/images/arrow.png') }}" alt=" " class="img-responsive" /></a>
            </div>
        </div>
        <div class="container">
            <p style="display: none;">&copy; 2016 Women's Fashion. All rights reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
            <p>&copy; 2021 <a href="https://enzo.fashion/">ENZO.FASHION</a> All rights reserved. <a href="javaScript:void(0)" style="display: none;">Developed by M NIPUN SARKER</a></p>
        </div>
    </div>
</div>
<!-- //footer -->
</body>
</html>

<script type="text/javascript">

    $( document ).ready(function() {

        if(('{{ Route::current()->getName() }}' != 'customer.create') && ('{{ Route::current()->getName() }}' != 'customer_forgot_password') && ('{{ Route::current()->getName() }}' != 'customer_reset_password_link') && ('{{ Route::current()->getName() }}' != 'order_detail') && ('{{ count($errors) }}' > 0)){
            $('#myModal88').modal('show');
        }

        if('{{ Session::has('error_message') }}'){
            $('#myModal88').modal('show');
        }

    });

</script>