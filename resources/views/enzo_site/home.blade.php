<?php use App\Http\Controllers\Website\HomeController;?>

@extends('enzo_site.layout')

@section('content')
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        {{--<li data-target="#myCarousel" data-slide-to="2"></li>--}}
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="{{ asset('enzo_website_assets/images/cover_polo_2.jpg') }}" alt="ENZO">
        </div>

        <div class="item">
            <img src="{{ asset('enzo_website_assets/images/enzo_cover.jpg') }}" alt="ENZO">
        </div>

        <div class="item">
            <img src="{{ asset('enzo_website_assets/images/cover_polo_3.jpg') }}" alt="ENZO">
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- //banner -->

<!-- banner-bottom -->
	<div class="banner-bottom">
		<div class="container">
			<div class="col-md-4 wthree_banner_bottom_left">
				<div class="video-img">
					<a class="play-icon popup-with-zoom-anim" href="#small-dialog">
						<span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
					</a>
				</div>
				<!-- pop-up-box -->
						<link href="{{ asset('enzo_website_assets/css/popuo-box.css') }}" rel="stylesheet" type="text/css" property="" media="all" />
						<script src="{{ asset('enzo_website_assets/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>
					<!--//pop-up-box -->
					<div id="small-dialog" class="mfp-hide">
						<iframe src=""></iframe>
					</div>
					<script>
						$(document).ready(function() {
						$('.popup-with-zoom-anim').magnificPopup({
							type: 'inline',
							fixedContentPos: false,
							fixedBgPos: true,
							overflowY: 'auto',
							closeBtnInside: true,
							preloader: false,
							midClick: true,
							removalDelay: 300,
							mainClass: 'my-mfp-zoom-in'
						});

						});
					</script>
			</div>
			<div class="col-md-8 wthree_banner_bottom_right">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">

                        @foreach($sub_category_list as $k => $sub_category)
                            @php
                                $sub_cat_lastest_prods_count = sizeof(HomeController::getProductsBySubcategoryId($sub_category->id, 4));
                            @endphp

                            @if($sub_cat_lastest_prods_count > 0)
                                <li role="presentation" @if($k == 0) class="active" @endif><a href="#{{ $k }}" role="tab" id="{{ $k }}-tab" data-toggle="tab" aria-controls="{{ $k }}">{{ $sub_category->sub_category_name }}</a></li>
                            @endif

                        @endforeach

					</ul>

					<div id="myTabContent" class="tab-content">
                        @foreach($sub_category_list as $k => $sub_category)
                            <div role="tabpanel" class="tab-pane fade @if($k == 0) active in @endif" id="{{ $k }}" aria-labelledby="{{ $k }}-tab">

                                <div class="text-right">
                                    <a href="{{ route('product_list', $sub_category->id) }}">View All</a>
                                </div>

                                <div class="agile_ecommerce_tabs">
                                    @php
                                        $sub_cat_lastest_prods = HomeController::getProductsBySubcategoryId($sub_category->id, 3);
                                    @endphp

                                    @foreach($sub_cat_lastest_prods as $sub_cat_lastest_prod)
                                        <div class="col-md-4 agile_ecommerce_tab_left">
                                            <div class="hs-wrapper">
                                                @foreach($sub_cat_lastest_prod->productimages as $product_image)
                                                    <img src="{{ asset('storage/uploads/'.$product_image->image_url) }}" alt=" " class="img-responsive" />
                                                @endforeach

                                                <div class="w3_hs_bottom">
                                                    <ul>
                                                        <li>
                                                            <a href="javaScript:void(0)" data-toggle="modal" data-target="#myModal" onclick="viewProductShortDetail({{ $sub_cat_lastest_prod->id }})"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <h5><a href="{{ route('view_single_product', $sub_cat_lastest_prod->id) }}">{{ $sub_cat_lastest_prod->product_name }}</a></h5>
                                            <div class="simpleCart_shelfItem">
                                                <p>
													{{--<span>$320</span> --}}
													<i class="item_price">
														৳ {{ $sub_cat_lastest_prod->price_in_bdt }}
													</i></p>
                                                <p><a class="" href="{{ route('view_single_product', $sub_cat_lastest_prod->id) }}">View Detail</a></p>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        @endforeach

					</div>
				</div>
					<!--modal-video-->
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

										{{--<div class="rating">--}}
											{{--<div class="rating-left">--}}
												{{--<img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="{{ asset('enzo_website_assets/images/star-.png') }}" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="clearfix"> </div>--}}
										{{--</div>--}}

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
				<div class="modal video-modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="images/40.jpeg" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4>a good look black women's jeans</h4>
										<p>Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										<div class="rating">
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="clearfix"> </div>
										</div>
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p><span>$320</span> <i class="item_price">$250</i></p>
											<p><a class="item_add" href="#">Add to cart</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul>
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
				<div class="modal video-modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="images/23.jpg" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4>a good look women's Watch</h4>
										<p>Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										<div class="rating">
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="clearfix"> </div>
										</div>
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p><span>$320</span> <i class="item_price">$250</i></p>
											<p><a class="item_add" href="#">Add to cart</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul>
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
				<div class="modal video-modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModal3">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="images/24.jpg" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4>a good look women's Sandal</h4>
										<p>Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										<div class="rating">
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="clearfix"> </div>
										</div>
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p><span>$320</span> <i class="item_price">$250</i></p>
											<p><a class="item_add" href="#">Add to cart</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul>
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
				<div class="modal video-modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModal4">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="images/22.jpg" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4>a good look women's Necklace</h4>
										<p>Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										<div class="rating">
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="clearfix"> </div>
										</div>
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p><span>$320</span> <i class="item_price">$250</i></p>
											<p><a class="item_add" href="#">Add to cart</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul>
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
				<div class="modal video-modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModal5">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="images/31.jpeg" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4>a good look women's Jacket</h4>
										<p>Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										<div class="rating">
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star-.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="rating-left">
												<img src="images/star.png" alt=" " class="img-responsive" />
											</div>
											<div class="clearfix"> </div>
										</div>
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p><span>$320</span> <i class="item_price">$250</i></p>
											<p><a class="item_add" href="#">Add to cart</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul>
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
				<div class="modal video-modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModal6">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<section>
								<div class="modal-body">
									<div class="col-md-5 modal_body_left">
										<img src="{{ asset('enzo_website_assets/images/27.jpeg') }}" alt=" " class="img-responsive" />
									</div>
									<div class="col-md-7 modal_body_right">
										<h4 id="product_name_1">a good look women's Long Skirt</h4>
										<span id="product_code_1">Product Code: Style 1</span>
										<p id="short_description_1">Ut enim ad minim veniam, quis nostrud
											exercitation ullamco laboris nisi ut aliquip ex ea
											commodo consequat.Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur sint occaecat
											cupidatat non proident, sunt in culpa qui officia
											deserunt mollit anim id est laborum.</p>
										{{--<div class="rating">--}}
											{{--<div class="rating-left">--}}
												{{--<img src="images/star-.png" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="images/star-.png" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="images/star-.png" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="images/star.png" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="rating-left">--}}
												{{--<img src="images/star.png" alt=" " class="img-responsive" />--}}
											{{--</div>--}}
											{{--<div class="clearfix"> </div>--}}
										{{--</div>--}}
										<div class="modal_body_right_cart simpleCart_shelfItem">
											<p>
												{{--<span>$320</span> --}}
												<i class="item_price">$250</i>
											</p>
											<p><a class="" href="#">View Detail</a></p>
										</div>
										<h5>Color</h5>
										<div class="color-quality">
											<ul id="colors_1">
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
                <div class="modal video-modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModal6">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <section>
                                <div class="modal-body">
                                    <div class="col-md-5 modal_body_left">
                                        <img src="images/30.jpeg" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="col-md-7 modal_body_right">
                                        <h4>a good look women's Dresses</h4>
                                        <p>Ut enim ad minim veniam, quis nostrud
                                            exercitation ullamco laboris nisi ut aliquip ex ea
                                            commodo consequat.Duis aute irure dolor in
                                            reprehenderit in voluptate velit esse cillum dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat
                                            cupidatat non proident, sunt in culpa qui officia
                                            deserunt mollit anim id est laborum.</p>
                                        <div class="rating">
                                            <div class="rating-left">
                                                <img src="images/star-.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="rating-left">
                                                <img src="images/star-.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="rating-left">
                                                <img src="images/star-.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="rating-left">
                                                <img src="images/star.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="rating-left">
                                                <img src="images/star.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="modal_body_right_cart simpleCart_shelfItem">
                                            <p><span>$320</span> <i class="item_price">$250</i></p>
                                            <p><a class="item_add" href="#">Add to cart</a></p>
                                        </div>
                                        <h5>Color</h5>
                                        <div class="color-quality">
                                            <ul>
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
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //banner-bottom -->

<!-- banner-bottom1 -->
	{{--<div class="banner-bottom1">--}}
		{{--<div class="agileinfo_banner_bottom1_grids">--}}
			{{--<div class="col-md-7 agileinfo_banner_bottom1_grid_left">--}}
				{{--<h3>Grand Opening Event With flat<span>20% <i>Discount</i></span></h3>--}}
				{{--<a href="products.php">Shop Now</a>--}}
			{{--</div>--}}
			{{--<div class="col-md-5 agileinfo_banner_bottom1_grid_right">--}}
				{{--<h4>hot deal</h4>--}}
				{{--<div class="timer_wrap">--}}
					{{--<div id="counter"> </div>--}}
				{{--</div>--}}
				{{--<script src="js/jquery.countdown.js"></script>--}}
				{{--<script src="js/script.js"></script>--}}
			{{--</div>--}}
			{{--<div class="clearfix"> </div>--}}
		{{--</div>--}}
	{{--</div>--}}
<!-- //banner-bottom1 -->

<!-- special-deals -->
	{{--<div class="special-deals">--}}
		{{--<div class="container">--}}
			{{--<h2>Special Deals</h2>--}}
			{{--<div class="w3agile_special_deals_grids">--}}
				{{--<div class="col-md-7 w3agile_special_deals_grid_left">--}}
					{{--<div class="w3agile_special_deals_grid_left_grid">--}}
						{{--<img src="images/26.jpg" alt=" " class="img-responsive" />--}}
						{{--<div class="w3agile_special_deals_grid_left_grid_pos1">--}}
							{{--<h5>30%<span>Off/-</span></h5>--}}
						{{--</div>--}}
						{{--<div class="w3agile_special_deals_grid_left_grid_pos">--}}
							{{--<h4>We Offer <span>Best Products</span></h4>--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div class="wmuSlider example1">--}}
						{{--<div class="wmuSliderWrapper">--}}
							{{--<article style="position: absolute; width: 100%; opacity: 0;"> --}}
								{{--<div class="banner-wrap">--}}
									{{--<div class="w3agile_special_deals_grid_left_grid1">--}}
										{{--<img src="images/1.png" alt=" " class="img-responsive" />--}}
										{{--<p>Quis autem vel eum iure reprehenderit qui in ea voluptate --}}
											{{--velit esse quam nihil molestiae consequatur, vel illum qui dolorem --}}
											{{--eum fugiat quo voluptas nulla pariatur</p>--}}
										{{--<h4>Laura</h4>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--</article>--}}
							{{--<article style="position: absolute; width: 100%; opacity: 0;"> --}}
								{{--<div class="banner-wrap">--}}
									{{--<div class="w3agile_special_deals_grid_left_grid1">--}}
										{{--<img src="images/2.png" alt=" " class="img-responsive" />--}}
										{{--<p>Quis autem vel eum iure reprehenderit qui in ea voluptate --}}
											{{--velit esse quam nihil molestiae consequatur, vel illum qui dolorem --}}
											{{--eum fugiat quo voluptas nulla pariatur</p>--}}
										{{--<h4>Michael</h4>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--</article>--}}
							{{--<article style="position: absolute; width: 100%; opacity: 0;"> --}}
								{{--<div class="banner-wrap">--}}
									{{--<div class="w3agile_special_deals_grid_left_grid1">--}}
										{{--<img src="images/3.png" alt=" " class="img-responsive" />--}}
										{{--<p>Quis autem vel eum iure reprehenderit qui in ea voluptate --}}
											{{--velit esse quam nihil molestiae consequatur, vel illum qui dolorem --}}
											{{--eum fugiat quo voluptas nulla pariatur</p>--}}
										{{--<h4>Rosy</h4>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--</article>--}}
						{{--</div>--}}
					{{--</div>--}}
						{{--<script src="js/jquery.wmuSlider.js"></script> --}}
						{{--<script>--}}
							{{--$('.example1').wmuSlider();         --}}
						{{--</script> --}}
				{{--</div>--}}
				{{--<div class="col-md-5 w3agile_special_deals_grid_right">--}}
					{{--<img src="images/25.jpg" alt=" " class="img-responsive" />--}}
					{{--<div class="w3agile_special_deals_grid_right_pos">--}}
						{{--<h4>Women's <span>Special</span></h4>--}}
						{{--<h5>save up <span>to</span> 30%</h5>--}}
					{{--</div>--}}
				{{--</div>--}}
				{{--<div class="clearfix"> </div>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
<!-- //special-deals -->
<!-- new-products -->
	<div class="new-products">
		<div class="container">
			<h3>New Products</h3>

			<div class="agileinfo_new_products_grids">

				@foreach($new_products as $new_product)
					<div class="col-md-3 agileinfo_new_products_grid">
						<div class="agile_ecommerce_tab_left agileinfo_new_products_grid1">
							<div class="hs-wrapper hs-wrapper1">
								@foreach($new_product->productimages as $product_image)
									<img src="{{ asset('storage/uploads/'.$product_image->image_url) }}" alt=" " class="img-responsive" />
								@endforeach

								<div class="w3_hs_bottom w3_hs_bottom_sub">
									<ul>
										<li>
											<a href="javaScript:void(0)" data-toggle="modal" data-target="#myModal" onclick="viewProductShortDetail({{ $new_product->id }})"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
										</li>
									</ul>
								</div>
							</div>
							<h5><a href="{{ route('view_single_product', $new_product->id) }}">{{ $new_product->product_name }}</a></h5>
							<div class="simpleCart_shelfItem">
								<p>
									{{--<span>$320</span> --}}
									<i class="item_price">
										৳ {{ $new_product->price_in_bdt }}
									</i>
								</p>
								<p><a class="item_add" href="{{ route('view_single_product', $new_product->id) }}">View Detail</a></p>
							</div>
						</div>
					</div>
				@endforeach

				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //new-products -->
<!-- top-brands -->
	{{--<div class="top-brands">--}}
		{{--<div class="container">--}}
			{{--<h3>Top Brands</h3>--}}
			{{--<div class="sliderfig">--}}
				{{--<ul id="flexiselDemo1">--}}
					{{--<li>--}}
						{{--<img src="{{ asset('enzo_website_assets/images/4.png') }}" alt=" " class="img-responsive" />--}}
					{{--</li>--}}
					{{--<li>--}}
						{{--<img src="{{ asset('enzo_website_assets/images/5.png') }}" alt=" " class="img-responsive" />--}}
					{{--</li>--}}
					{{--<li>--}}
						{{--<img src="{{ asset('enzo_website_assets/images/6.png') }}" alt=" " class="img-responsive" />--}}
					{{--</li>--}}
					{{--<li>--}}
						{{--<img src="{{ asset('enzo_website_assets/images/7.png') }}" alt=" " class="img-responsive" />--}}
					{{--</li>--}}
					{{--<li>--}}
						{{--<img src="{{ asset('enzo_website_assets/images/46.png') }}" alt=" " class="img-responsive" />--}}
					{{--</li>--}}
				{{--</ul>--}}
			{{--</div>--}}
					{{--<script type="text/javascript">--}}
							{{--$(window).load(function() {--}}
								{{--$("#flexiselDemo1").flexisel({--}}
									{{--visibleItems: 4,--}}
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
<!-- //top-brands -->
<!-- newsletter -->
	{{--<div class="newsletter">--}}
		{{--<div class="container">--}}
			{{--<div class="col-md-6 w3agile_newsletter_left">--}}
				{{--<h3>Newsletter</h3>--}}
				{{--<p>Excepteur sint occaecat cupidatat non proident, sunt.</p>--}}
			{{--</div>--}}
			{{--<div class="col-md-6 w3agile_newsletter_right">--}}
				{{--<form action="#" method="post">--}}
					{{--<input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">--}}
					{{--<input type="submit" value="" />--}}
				{{--</form>--}}
			{{--</div>--}}
			{{--<div class="clearfix"> </div>--}}
		{{--</div>--}}
	{{--</div>--}}
<!-- //newsletter -->

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