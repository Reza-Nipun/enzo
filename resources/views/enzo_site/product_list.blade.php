@extends('enzo_site.layout')

@section('content')

    <!-- banner -->
    <div class="">
        <img src="{{ asset('enzo_website_assets/images/cover_polo_other.jpg') }}" width="100%">
    </div>
    <!-- //banner -->

    <!-- breadcrumbs -->
    <div class="breadcrumb_dress">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></li>
                <li>{{ $sub_cat_info->sub_category_name }}</li>
            </ul>
        </div>
    </div>
    <!-- //breadcrumbs -->

    {{--<div class="dresses">--}}
        <div class="container">
            <div class="w3ls_dresses_grids">

                <div class="col-md-12 w3ls_dresses_grid_right">

                    <div class="w3ls_dresses_grid_right_grid2">
                        {{--<div class="w3ls_dresses_grid_right_grid2_left">--}}
                            {{--<h3>Showing Results: 0-1</h3>--}}
                        {{--</div>--}}
                        {{--<div class="w3ls_dresses_grid_right_grid2_right">--}}
                            {{--<select name="select_item" class="select_item">--}}
                                {{--<option selected="selected">Default sorting</option>--}}
                                {{--<option>Sort by popularity</option>--}}
                                {{--<option>Sort by average rating</option>--}}
                                {{--<option>Sort by newness</option>--}}
                                {{--<option>Sort by price: low to high</option>--}}
                                {{--<option>Sort by price: high to low</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        <div class="clearfix"> </div>
                    </div>
                    <div class="w3ls_dresses_grid_right_grid3">

                        @foreach($products as $product)
                            <div class="col-md-3 agileinfo_new_products_grid agileinfo_new_products_grid_dresses">
                                <div class="agile_ecommerce_tab_left dresses_grid">
                                    <div class="hs-wrapper hs-wrapper2">
                                        @foreach($product->productimages as $product_image)
                                            <img src="{{ asset('storage/uploads/'.$product_image->image_url) }}" alt=" " class="img-responsive" />
                                        @endforeach
                                        <div class="w3_hs_bottom w3_hs_bottom_sub1">
                                            <ul>
                                                <li>
                                                    <a href="javaScript:void(0)" onclick="viewProductShortDetail({{ $product->id }})"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h5><a href="{{ route('view_single_product', $product->id) }}">{{ $product->product_name }}</a></h5>
                                    <div class="simpleCart_shelfItem">
                                        <p>
                                            {{--<span>$420</span> --}}
                                            <i class="item_price">৳ {{ $product->price_in_bdt }}</i>
                                        </p>
                                        <p><a class="" href="{{ route('view_single_product', $product->id) }}">View Detail</a></p>
                                    </div>
                                    {{--<div class="dresses_grid_pos">--}}
                                        {{--<h6>New</h6>--}}
                                    {{--</div>--}}
                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="row text-center">
                {{ $products->links() }}
            </div>
        </div>
    <div class="clearfix"> </div>
    <div class="clearfix"> </div>
        {{--<div class="w3l_related_products">--}}
            {{--<div class="container">--}}
                {{--<h2 style="color: white">.</h2>--}}
                {{--<div class="w3agile_newsletter_left">--}}
                    {{--<h3>Related Products</h3>--}}
                {{--</div>--}}
                {{--<ul id="flexiselDemo2">--}}
                    {{--<li>--}}
                        {{--<div class="w3l_related_products_grid">--}}
                            {{--<div class="agile_ecommerce_tab_left dresses_grid">--}}
                                {{--<div class="hs-wrapper hs-wrapper3">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/31.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/32.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/33.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/34.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/31.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/32.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/33.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/34.jpeg') }}" alt=" " class="img-responsive">--}}
                                    {{--<div class="w3_hs_bottom">--}}
                                        {{--<div class="flex_ecommerce">--}}
                                            {{--<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<h5><a href="single.php">Sweater</a></h5>--}}
                                {{--<div class="simpleCart_shelfItem">--}}
                                    {{--<p class="flexisel_ecommerce_cart"><span>$312</span> <i class="item_price">$212</i></p>--}}
                                    {{--<p><a class="item_add" href="#">View Detail</a></p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="w3l_related_products_grid">--}}
                            {{--<div class="agile_ecommerce_tab_left dresses_grid">--}}
                                {{--<div class="hs-wrapper hs-wrapper3">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/32.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/31.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/33.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/34.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/31.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/32.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/33.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/34.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<div class="w3_hs_bottom">--}}
                                        {{--<div class="flex_ecommerce">--}}
                                            {{--<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<h5><a href="single.php">Sweater</a></h5>--}}
                                {{--<div class="simpleCart_shelfItem">--}}
                                    {{--<p class="flexisel_ecommerce_cart"><span>$432</span> <i class="item_price">$323</i></p>--}}
                                    {{--<p><a class="item_add" href="#">View Detail</a></p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="w3l_related_products_grid">--}}
                            {{--<div class="agile_ecommerce_tab_left dresses_grid">--}}
                                {{--<div class="hs-wrapper hs-wrapper3">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/41.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/42.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/43.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/44.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/41.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/42.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/43.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/44.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<div class="w3_hs_bottom">--}}
                                        {{--<div class="flex_ecommerce">--}}
                                            {{--<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<h5><a href="single.php">Sweater</a></h5>--}}
                                {{--<div class="simpleCart_shelfItem">--}}
                                    {{--<p class="flexisel_ecommerce_cart"><span>$323</span> <i class="item_price">$310</i></p>--}}
                                    {{--<p><a class="item_add" href="#">View Detail</a></p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="w3l_related_products_grid">--}}
                            {{--<div class="agile_ecommerce_tab_left dresses_grid">--}}
                                {{--<div class="hs-wrapper hs-wrapper3">--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/36.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/37.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/30.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/38.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/37.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/30.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/36.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<img src="{{ asset('enzo_website_assets/images/38.jpeg') }}" alt=" " class="img-responsive" />--}}
                                    {{--<div class="w3_hs_bottom">--}}
                                        {{--<div class="flex_ecommerce">--}}
                                            {{--<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<h5><a href="single.php">Sweater</a></h5>--}}
                                {{--<div class="simpleCart_shelfItem">--}}
                                    {{--<p class="flexisel_ecommerce_cart"><span>$256</span> <i class="item_price">$200</i></p>--}}
                                    {{--<p><a class="item_add" href="#">View Detail</a></p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<script type="text/javascript">--}}
                    {{--$(window).load(function() {--}}
                        {{--$("#flexiselDemo2").flexisel({--}}
                            {{--visibleItems:4,--}}
                            {{--animationSpeed: 1000,--}}
                            {{--autoPlay: true,--}}
                            {{--autoPlaySpeed: 3000,--}}
                            {{--pauseOnHover: true,--}}
                            {{--enableResponsiveBreakpoints: true,--}}
                            {{--responsiveBreakpoints: {--}}
                                {{--portrait: {--}}
                                    {{--changePoint:480,--}}
                                    {{--visibleItems: 1--}}
                                {{--},--}}
                                {{--landscape: {--}}
                                    {{--changePoint:640,--}}
                                    {{--visibleItems:2--}}
                                {{--},--}}
                                {{--tablet: {--}}
                                    {{--changePoint:768,--}}
                                    {{--visibleItems: 3--}}
                                {{--}--}}
                            {{--}--}}
                        {{--});--}}

                    {{--});--}}
                {{--</script>--}}
                {{--<script type="text/javascript" src="{{ asset('enzo_website_assets/js/jquery.flexisel.js') }}"></script>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<!-- //dresses -->

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
                                <p><a class="" href="javaScript:void(0)" id="view_detail_product">View Detail</a></p>
                            </div>
                            <h5>Color</h5>
                            <div class="color-quality">
                                <ul id="colors">
                                    <li><a href="javaScript:void(0)"><span></span>Red</a></li>
                                    <li><a href="javaScript:void(0)" class="brown"><span></span>Yellow</a></li>
                                    <li><a href="javaScript:void(0)" class="purple"><span></span>Purple</a></li>
                                    <li><a href="javaScript:void(0)" class="gray"><span></span>Violet</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
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

    </script>
@endsection