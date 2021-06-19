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
                    <ul class="slides">
                        @foreach($product_images as $product_image)
                            <li data-thumb="{{ asset('storage/uploads/'.$product_image->image_url) }}">
                                <div class="thumb-image"> <img src="{{ asset('storage/uploads/'.$product_image->image_url) }}" data-imagezoom="true" class="img-responsive"> </div>
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
                <input type="hidden" value="{{ $product_info->id }}" readonly="readonly" name="product_id" id="product_id">
                <input type="hidden" value="{{ $product_info->product_name }}" readonly="readonly" name="product_name" id="product_name">
                <input type="hidden" value="{{ $product_info->product_code }}" readonly="readonly" name="product_code" id="product_code">
                <input type="hidden" value="{{ $product_images[0]->color_id }}" readonly="readonly" name="color_id" id="color_id">
                <input type="hidden" value="{{ $product_colors[0]->color }}" readonly="readonly" name="color" id="color">
                <input type="hidden" readonly="readonly" name="size_id" id="size_id">
                <input type="hidden" readonly="readonly" name="size_name" id="size_name">
                <input type="hidden" readonly="readonly" name="size_description" id="size_description">
                <input type="hidden" value="{{ $product_info->price_in_bdt }}" readonly="readonly" name="price_in_bdt" id="price_in_bdt">
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
                    <p>{!! $product_info->product_short_description !!}</p>
                </div>
                <div class="color-quality">
                    <div class="color-quality-left">
                        <h5>Color: </h5>
                        <ul>
                            @foreach($product_colors as $product_color)
                                <li @if($product_images[0]->color_id == $product_color->id) style="border: dotted; border-color: #69d88a" @endif><a href="{{ route('view_single_product', [$product_info->id, $product_color->id]) }}"><span style="border-style: solid; width: 20px; background-color: {{ $product_color->color_code }}"></span> {{ $product_color->color }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="color-quality-right">
                        <h5>Quantity :</h5>
                        <div class="quantity">
                            <div class="quantity-select">
                                <div class="entry value-minus1">&nbsp;</div>
                                <input type="text" class="entry value1" id="order_qty" value="1" readonly="readonly">
                                <div class="entry value-plus1 active">&nbsp;</div>
                            </div>
                        </div>
                        <!--quantity-->
                        <script>
                            $('.value-plus1').on('click', function(){
                                var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.val(), 10)+1;
                                divUpd.val(newVal);
                            });

                            $('.value-minus1').on('click', function(){
                                var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.val(), 10)-1;
                                if(newVal>=1) divUpd.val(newVal);
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
                                <label class=""><input type="radio" name="size" id="size" class="" onclick="getAndSetSizeId('{{ $product_size->id }}', '{{ $product_size->size }}', '{{ $product_size->size_description }}')" style="width: 18px; height: 18px;"><i> </i>{{ $product_size->size.' - '.$product_size->size_description }}</label>
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
                    <p><a class="" href="javaScript:void(0)" onclick="addToCart()">Add to cart</a></p>
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
                @foreach($related_products as $related_product)
                    <li>
                        <div class="w3l_related_products_grid">
                            <div class="agile_ecommerce_tab_left dresses_grid">
                                <div class="hs-wrapper hs-wrapper3">

                                    @foreach($related_product->productimages as $product_image)
                                        <img src="{{ asset('storage/uploads/'.$product_image->image_url) }}" alt=" " class="img-responsive">
                                    @endforeach

                                    <div class="w3_hs_bottom">
                                        <div class="flex_ecommerce">
                                            <a href="javaScript:void(0)" data-toggle="modal" data-target="#myModal" onclick="viewProductShortDetail({{ $related_product->id }})"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <h5><a href="{{ route('view_single_product', $related_product->id) }}">{{ $related_product->product_name }}</a></h5>
                                <div class="simpleCart_shelfItem">
                                    <p class="flexisel_ecommerce_cart">
                                        {{--<span>৳ {{ $related_product->price_in_bdt }}</span>--}}
                                        <i class="item_price">{{ $related_product->price_in_bdt }}</i>
                                    </p>
                                    <p><a class="item_add" href="{{ route('view_single_product', $related_product->id) }}">View Detail</a></p>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
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
            <script type="text/javascript" src="{{ asset('enzo_website_assets/js/jquery.flexisel.js') }}"></script>
        </div>
    </div>

        <div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <section>
                        <div class="modal-body">
                            <div class="col-md-5 modal_body_left" id="product_image">
                                <img src="{{ asset('enzo_website_assets/images/20.jpg') }}" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-md-7 modal_body_right">
                                <h4 id="product_name">a good look women's shirt</h4>
                                <span id="product_code">Product Code: Style 1</span>
                                <p id="short_description">Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.Duis aute irure dolor in
                                    reprehenderit in voluptate velit esse cillum dolore
                                    eu fugiat nulla pariatur. Excepteur sint occaecat
                                    cupidatat non proident, sunt in culpa qui officia
                                    deserunt mollit anim id est laborum.</p>

                                <div class="modal_body_right_cart simpleCart_shelfItem">
                                    <p>
                                        {{--<span>$320</span> --}}
                                        <i class="item_price" id="product_price_in_bdt">$ 250</i>
                                    </p>
                                    <p><a class="" href="#" id="view_detail_product">View Detail</a></p>
                                </div>
                                <h5>Color</h5>
                                <div class="color-quality">
                                    <ul id="colors">
                                        <li><a href="#"><span></span>Red</a></li>
                                        <li><a href="#" class="brown"><span></span>Yellow</a></li>
                                        <li><a href="#" class="purple"><span></span>Purple</a></li>
                                        <li><a href="#" class="gray"><span></span>Violet</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalCartCriteria" tabindex="-1" role="dialog" aria-labelledby="myModalCartCriteria">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <section>
                        <div class="modal-body modal-body-sub">
                            <div class="col-md-12">
                                <h4><span class="btn btn-sm btn-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> Please Select Product/Color/Size!</h4>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalStockOut" tabindex="-1" role="dialog" aria-labelledby="myModalStockOut">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <section>
                        <div class="modal-body modal-body-sub">
                            <div class="col-md-12">
                                <h4><span class="btn btn-sm btn-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> Sorry, This Product is Out of Stock!</h4>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalCart" tabindex="-1" role="dialog" aria-labelledby="myModalCart">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <section>
                        <div class="modal-body modal-body-sub">
                            <div class="col-md-12">
                                <h4><span class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></span> Product is Added to Your Cart List!</h4>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('get_cart_list') }}" class="btn btn-warning">CART LIST</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>


        <script type="text/javascript">

            function viewProductShortDetail(product_id){

                $('#product_name').empty();
                $('#product_code').empty();
                $('#short_description').empty();
                $('#colors').empty();
                $('#product_price_in_bdt').empty();
                $('#product_image').empty();

                $.ajax({
                    url: "{{ route("get_products_by_id") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", product_id: product_id},
                    dataType: "json",
                    success: function (data) {
                        $('#product_name').append(data[0].product_name);
                        $('#product_code').append('Product Code: '+data[0].product_code);
                        $('#short_description').append(data[0].product_short_description);
                        $('#product_price_in_bdt').append('৳ '+data[0].price_in_bdt);
                        $('#product_image').append('<img src="{{ asset('storage/uploads/') }}'+"/"+data[0].image_url+'" alt=" " class="img-responsive" />');

                        var a = document.getElementById('view_detail_product');
                        a.href = '{{ url('/view_single_product') }}'+"/"+product_id;

                        for(var i=0; i < data.length; i++ ){
                            $("#colors").append('<li><a href="javaScript:void(0)" onclick="getSelectedColorImage('+product_id+', '+data[i].color_id+')"><span style="border: solid; background-color: '+data[i].color_code+';"></span>'+data[i].color+'</a></li>');
                        }

                        $('#myModal').modal('show');
                    }
                });
            }

            function getSelectedColorImage(product_id, color_id) {

                $('#product_image').empty();

                $.ajax({
                    url: "{{ route("get_product_images") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", product_id: product_id, color_id: color_id},
                    dataType: "json",
                    success: function (data) {

                        $('#product_image').append('<img src="{{ asset('storage/uploads/') }}'+"/"+data[0].image_url+'" alt=" " class="img-responsive" />');

                        $('#myModal').modal('show');
                    }
                });
            }

            function getAndSetSizeId(size_id, size_name, size_description) {
                $("#size_id").val(size_id);
                $("#size_name").val(size_name);
                $("#size_description").val(size_description);
            }

            function addToCart() {
                var product_id = $("#product_id").val();
                var product_name = $("#product_name").val();
                var product_code = $("#product_code").val();
                var color_id = $("#color_id").val();
                var color = $("#color").val();
                var size_id = $("#size_id").val();
                var size_name = $("#size_name").val();
                var size_description = $("#size_description").val();
                var order_qty = $("#order_qty").val();
                var price_in_bdt = $("#price_in_bdt").val();

                if('{{ $customer_data['customer_id'] }}' == "") {
                    $('#myModal88').modal('show');
                }else{
                    if(product_id != '' && color_id != '' && size_id != ''){

                        $.ajax({
                            url: "{{ route("add_to_cart") }}",
                            type:'POST',
                            data: {_token:"{{csrf_token()}}", product_id: product_id, product_name: product_name, product_code: product_code, color_id: color_id, color: color, size_id: size_id, size_name: size_name, size_description: size_description, order_qty: order_qty, price_in_bdt: price_in_bdt},
                            dataType: "json",
                            success: function (data) {

                                if(data == 'failed'){
                                    $('#myModal88').modal('show');
                                } else if(data == 'na'){
                                    $('#myModalStockOut').modal('show');
                                }else{
                                    $("#simpleCart_quantity").text(data);
                                    $('#myModalCart').modal('show');
                                }

                            }
                        });

                    }else{
                        $('#myModalCartCriteria').modal('show');
                    }

                }


            }
        </script>
@endsection