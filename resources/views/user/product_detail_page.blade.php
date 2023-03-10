@extends('user.layouts.master')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('user#home') }}">Home</a>
                    <span class="breadcrumb-item active">Product Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/product_images/' . $product->image) }}"
                                alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <div class=" d-flex justify-content-between">
                        <h3>{{ $product->name }}</h3>
                        <small>{{ $product->view_count + 1 }}<i class=" ml-2 fas fa-eye"></i></small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $product->price }}ks</h3>
                    <p class="mb-4">{{ $product->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">

                        <input type="number" value="{{ Auth::user()->id }}" id="userId" hidden>
                        <input type="number" value="{{ $product->product_id }}" id="productId" hidden>

                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1"
                                id="productAmount">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3" id="addToCartBtn" type="button"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also
                Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($productList as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/product_images/' . $p->image) }}"
                                    alt="" style="height: 230px">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('user#showProductDetailPage', $p->product_id) }}"><i
                                            class="fas fa-info-circle"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }}ks</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
@section('jqueryCode')
    <script>
        $('document').ready(function() {

            // for view count
            $.ajax({
                type: 'get',
                url: '/user/ajax/viewCount',
                dataType: 'json',
                data: {
                    'productId': $('#productId').val()
                },
            })


            $('#addToCartBtn').click(function() {
                let cartData = {
                    'userId': $('#userId').val(),
                    'productId': $('#productId').val(),
                    'productAmount': $('#productAmount').val(),
                };

                if (cartData.productAmount != 0) {

                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/cart',
                        dataType: 'json',
                        data: cartData,
                        success: function(response) {
                            if (response.status == 'success') {
                                window.location.href = '/user/home';
                            }
                        }
                    })
                }

            })
        })
    </script>
@endsection
