@extends('front.layouts.app')

@section('title')
    Home Page
@endsection

@section('content')
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/store_6.jpg')}}" />
                        <source media="(max-width: 800px)" srcset="{{asset('front-assets/images/store_6.jpg')}}" />
                        <img src="{{asset('front-assets/images/store_6.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Laptop</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    
                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/cyber-monday-retail-sales.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/cyber-monday-retail-sales.jpg')}}" />
                        <img src="{{asset('front-assets/images/cyber-monday-retail-sales.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Mobile</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/tr_ai_2.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/tr_ai_2.jpg')}}" />
                        <img src="{{asset('front-assets/images/tr_ai_2.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>    
            <div class="row pb-3">
                @foreach ($products as $product)
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="" class="product-img"><img class="card-img-top" src="{{asset('uploads/products/'.$product->image)}}" alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                <div class="product-action">
                                    <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>                            
                                </div>
                            </div>                        
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">{{$product->title}}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>${{$product->price}}</strong></span>
                                    {{-- <span class="h6 text-underline"><del>$120</del></span> --}}
                                </div>
                            </div>                        
                        </div>                                               
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function addToCart(id){

            $.ajax({
                url: "{{route('add-cart')}}",
                type: 'post',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    console.log('ok');
                },
            });
        }
    </script>
@endsection