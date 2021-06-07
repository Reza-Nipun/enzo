<?php use App\Http\Controllers\Website\HomeController;?>

@extends('enzo_site.layout')

@section('content')
        {{--<div class="breadcrumb_dress">--}}
            {{--<div class="container">--}}
                {{--<ul>--}}
                    {{--<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></li>--}}
                    {{--<li>Single Page</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="single">
            <div class="container">
                <div class="col-md-4 single-left">
                    <div class="flexslider">
                        <ul class="slides" id="product_image">
                            @foreach($product_images as $product_image)
                                <li data-thumb="{{ asset('storage/app/public/uploads/'.$product_image->image_url) }}">
                                    <div class="thumb-image"> <img src="{{ asset('storage/app/public/uploads/'.$product_image->image_url) }}" data-imagezoom="true" class="img-responsive"> </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- flixslider -->
                    <script defer src="{{ asset('enzo_website_assets/js/jquery.flexslider.js') }}"></script>
                    <link rel="stylesheet" href="{{ asset('enzo_website_assets/css/flexslider.css') }}" type="text/css" media="screen" />
                    <script>
                        // Can also be used with $(document).ready()
                        $(window).load(function() {
                            $('.flexslider').flexslider({
                                animation: "slide",
                                controlNav: "thumbnails"
                            });
                        });
                    </script>
                    <!-- flixslider -->
                    <!-- zooming-effect -->
                    <script src="{{ asset('enzo_website_assets/js/imagezoom.js') }}"></script>
                    <!-- //zooming-effect -->
                </div>
                <div class="col-md-8 single-right">
                    <h3>{{ $product_info->product_name }}</h3>
                    <h5>Product Code: {{ $product_info->product_code }}</h5>
                    {{--<div class="rating1">--}}
					{{--<span class="starRating">--}}
						{{--<input id="rating5" type="radio" name="rating" value="5">--}}
						{{--<label for="rating5">5</label>--}}
						{{--<input id="rating4" type="radio" name="rating" value="4">--}}
						{{--<label for="rating4">4</label>--}}
						{{--<input id="rating3" type="radio" name="rating" value="3" checked>--}}
						{{--<label for="rating3">3</label>--}}
						{{--<input id="rating2" type="radio" name="rating" value="2">--}}
						{{--<label for="rating2">2</label>--}}
						{{--<input id="rating1" type="radio" name="rating" value="1">--}}
						{{--<label for="rating1">1</label>--}}
					{{--</span>--}}
                    {{--</div>--}}
                    <div class="description">
                        <h5><i>Short Description</i></h5>
                        <p>{{ $product_info->product_short_description }}</p>
                    </div>
                    <div class="color-quality">
                        <div class="color-quality-left">
                            <h5>Color: </h5>
                            <ul>
                                @foreach($product_colors as $product_color)
                                    <li><a href="{{ route('view_single_product', [$product_info->id, $product_color->id]) }}"><span style="border-style: solid; width: 20px; background-color: {{ $product_color->color_code }}"></span> {{ $product_color->color }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="color-quality-right">
                            <h5>Quantity :</h5>
                            <div class="quantity">
                                <div class="quantity-select">
                                    <div class="entry value-minus1">&nbsp;</div>
                                    <div class="entry value1"><span>1</span></div>
                                    <div class="entry value-plus1 active">&nbsp;</div>
                                </div>
                            </div>
                            <!--quantity-->
                            <script>
                                $('.value-plus1').on('click', function(){
                                    var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10)+1;
                                    divUpd.text(newVal);
                                });

                                $('.value-minus1').on('click', function(){
                                    var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10)-1;
                                    if(newVal>=1) divUpd.text(newVal);
                                });
                            </script>
                            <!--quantity-->

                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="occasional">
                        <h5>Size :</h5>

                        @foreach($product_sizes as $product_size)
                            <div class="colr ert">
                                <div class="check">
                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i> </i>{{ $product_size->size.' - '.$product_size->size_description }}</label>
                                </div>
                            </div>
                        @endforeach

                        <div class="clearfix"> </div>
                    </div>
                    <div class="simpleCart_shelfItem">
                        <p>
                            {{--<span>$320</span> --}}
                            <i class="item_price">৳ {{ $product_info->price_in_bdt }}</i>
                        </p>
                        <p><a class="" href="javaScript:void(0)">Add to cart</a></p>
                    </div>
                    <div class="occasional">
                        <h5><i>Product Detail</i></h5>

                        <div class="panel-group" id="accordion">

                            @foreach($product_specifications as $k => $product_specification)
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <h4><a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $k }}">{{ $product_specification->specification_name }}</a> <i class="fas fa-angle-down"></i></h4>
                                        </h4>
                                    </div>
                                    <div id="collapse{{ $k }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            @php

                                                $product_specification_tags_array = explode (",", $product_specification->specification_description);

                                            @endphp

                                            @foreach($product_specification_tags_array as $product_specification_tag)

                                                @if(!empty($product_specification_tag))

                                                        <span class="" style="font-size: 13px; background-color: rgba(89,106,29,0.1); color: #000000;">
                                                        {{ $product_specification_tag }}
                                                        </span><br />

                                                @endif

                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>




    <div class="">
        <div class="container">
            <div class="sap_tabs">
                <div id="horizontalTab1" style="display: block; width: 100%; margin: 0px;">
                    <ul>
                        <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>Reviews</span></li>
                    </ul>
                    <div class="tab-2 resp-tab-content additional_info_grid" aria-labelledby="tab_item-1">
                        <h4>(2) Reviews</h4>
                        <div class="additional_info_sub_grids">
                            <div class="col-xs-2 additional_info_sub_grid_left">
                                <img src="{{ asset('enzo_website_assets/images/1.png') }}" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-xs-10 additional_info_sub_grid_right">
                                <div class="additional_info_sub_grid_rightl">
                                    <a href="single.php">Laura</a>
                                    <h5>April 03, 2016.</h5>
                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate
                                        velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat
                                        quo voluptas nulla pariatur.</p>
                                </div>
                                <div class="additional_info_sub_grid_rightr">
                                    <div class="rating">
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="additional_info_sub_grids">
                            <div class="col-xs-2 additional_info_sub_grid_left">
                                <img src="{{ asset('enzo_website_assets/images/2.png') }}" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-xs-10 additional_info_sub_grid_right">
                                <div class="additional_info_sub_grid_rightl">
                                    <a href="single.php">Michael</a>
                                    <h5>April 04, 2016.</h5>
                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate
                                        velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat
                                        quo voluptas nulla pariatur.</p>
                                </div>
                                <div class="additional_info_sub_grid_rightr">
                                    <div class="rating">
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="rating-left">
                                            <img src="{{ asset('enzo_website_assets/images/star.png') }}" alt=" " class="img-responsive">
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="review_grids">
                            <h5>Add A Review</h5>
                            <form action="#" method="post">
                                <input type="text" name="Name" value="Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}" required="">
                                <input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
                                <input type="text" name="Telephone" value="Telephone" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Telephone';}" required="">
                                <textarea name="Review" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Add Your Review';}" required="">Add Your Review</textarea>
                                <input type="submit" value="Submit" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#horizontalTab1').easyResponsiveTabs({
                        type: 'default', //Types: default, vertical, accordion
                        width: 'auto', //auto or any width like 600px
                        fit: true   // 100% fit in a container
                    });
                });
            </script>
        </div>
    </div>

    <div class="w3l_related_products">
        <div class="container">
            <h3>Related Products</h3>
            <ul id="flexiselDemo2">
                <li>
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div class="hs-wrapper hs-wrapper3">
                                <img src="images/ss1.jpg" alt=" " class="img-responsive">
                                <img src="images/ss2.jpg" alt=" " class="img-responsive">
                                <img src="images/ss3.jpg" alt=" " class="img-responsive">
                                <img src="images/ss4.jpg" alt=" " class="img-responsive">
                                <img src="images/ss5.jpg" alt=" " class="img-responsive">
                                <img src="images/ss6.jpg" alt=" " class="img-responsive">
                                <img src="images/ss7.jpg" alt=" " class="img-responsive">
                                <img src="images/ss8.jpg" alt=" " class="img-responsive">
                                <div class="w3_hs_bottom">
                                    <div class="flex_ecommerce">
                                        <a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            </div>
                            <h5><a href="single.php">Pink Flared Skirt</a></h5>
                            <div class="simpleCart_shelfItem">
                                <p class="flexisel_ecommerce_cart"><span>$312</span> <i class="item_price">$212</i></p>
                                <p><a class="item_add" href="#">Add to cart</a></p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div class="hs-wrapper hs-wrapper3">
                                <img src="images/ss2.jpg" alt=" " class="img-responsive">
                                <img src="images/ss3.jpg" alt=" " class="img-responsive">
                                <img src="images/ss4.jpg" alt=" " class="img-responsive">
                                <img src="images/ss5.jpg" alt=" " class="img-responsive">
                                <img src="images/ss6.jpg" alt=" " class="img-responsive">
                                <img src="images/ss9.jpg" alt=" " class="img-responsive">
                                <img src="images/ss7.jpg" alt=" " class="img-responsive">
                                <img src="images/ss8.jpg" alt=" " class="img-responsive">
                                <div class="w3_hs_bottom">
                                    <div class="flex_ecommerce">
                                        <a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            </div>
                            <h5><a href="single.php">Red Pencil Skirt</a></h5>
                            <div class="simpleCart_shelfItem">
                                <p class="flexisel_ecommerce_cart"><span>$432</span> <i class="item_price">$323</i></p>
                                <p><a class="item_add" href="#">Add to cart</a></p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div class="hs-wrapper hs-wrapper3">
                                <img src="images/ss3.jpg" alt=" " class="img-responsive">
                                <img src="images/ss4.jpg" alt=" " class="img-responsive">
                                <img src="images/ss5.jpg" alt=" " class="img-responsive">
                                <img src="images/ss6.jpg" alt=" " class="img-responsive">
                                <img src="images/ss7.jpg" alt=" " class="img-responsive">
                                <img src="images/ss8.jpg" alt=" " class="img-responsive">
                                <img src="images/ss9.jpg" alt=" " class="img-responsive">
                                <img src="images/ss1.jpg" alt=" " class="img-responsive">
                                <div class="w3_hs_bottom">
                                    <div class="flex_ecommerce">
                                        <a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            </div>
                            <h5><a href="single.php">Yellow Cotton Skirt</a></h5>
                            <div class="simpleCart_shelfItem">
                                <p class="flexisel_ecommerce_cart"><span>$323</span> <i class="item_price">$310</i></p>
                                <p><a class="item_add" href="#">Add to cart</a></p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="w3l_related_products_grid">
                        <div class="agile_ecommerce_tab_left dresses_grid">
                            <div class="hs-wrapper hs-wrapper3">
                                <img src="images/ss4.jpg" alt=" " class="img-responsive">
                                <img src="images/ss5.jpg" alt=" " class="img-responsive">
                                <img src="images/ss6.jpg" alt=" " class="img-responsive">
                                <img src="images/ss7.jpg" alt=" " class="img-responsive">
                                <img src="images/ss8.jpg" alt=" " class="img-responsive">
                                <img src="images/ss9.jpg" alt=" " class="img-responsive">
                                <img src="images/ss1.jpg" alt=" " class="img-responsive">
                                <img src="images/ss2.jpg" alt=" " class="img-responsive">
                                <div class="w3_hs_bottom">
                                    <div class="flex_ecommerce">
                                        <a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            </div>
                            <h5><a href="single.php">Black Short</a></h5>
                            <div class="simpleCart_shelfItem">
                                <p class="flexisel_ecommerce_cart"><span>$256</span> <i class="item_price">$200</i></p>
                                <p><a class="item_add" href="#">Add to cart</a></p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <script type="text/javascript">
                $(window).load(function() {
                    $("#flexiselDemo2").flexisel({
                        visibleItems:4,
                        animationSpeed: 1000,
                        autoPlay: true,
                        autoPlaySpeed: 3000,
                        pauseOnHover: true,
                        enableResponsiveBreakpoints: true,
                        responsiveBreakpoints: {
                            portrait: {
                                changePoint:480,
                                visibleItems: 1
                            },
                            landscape: {
                                changePoint:640,
                                visibleItems:2
                            },
                            tablet: {
                                changePoint:768,
                                visibleItems: 3
                            }
                        }
                    });

                });
            </script>
            <script type="text/javascript" src="js/jquery.flexisel.js"></script>
        </div>
    </div>

@endsection