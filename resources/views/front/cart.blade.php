@extends('front.layouts.app')

@section('title')
    Home Page
@endsection

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('home')}}">Home</a></li>
                    {{-- <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li> --}}
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($products->all()))
                                    {!! '<tr><td colspan="5">Empty Product</td></tr>' !!}
                                @else
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-xl-start">
                                                    <img src="{{asset('uploads/products/'.$product->image)}}" width="" height="">
                                                    <h2>{{$product->title}}</h2>
                                                </div>
                                            </td>
                                            <td>${{$product->price}}</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input type="hidden" name="quantity" value="{{$product->id}}">
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{$cartItems[$product->id]['quantity']}}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <input type="hidden" name="quantity" value="{{$product->id}}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                ${{$product->price * $cartItems[$product->id]['quantity']}}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="remove({{$product->id}})"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">            
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div> 
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{$total}}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$0</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{$total}}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{route('user.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>     
                    {{-- <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>  --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('.add').click(function(){
            var qtyElement = $(this).parent().prev();
            var qtyValue = parseInt(qtyElement.val());
            var product_id = $(this).next().val();
            
            if(qtyValue < 10){
                qtyElement.val(qtyValue + 1);
                updateQuantity(product_id, qtyElement.val());
            }
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            var product_id = $(this).next().val();

            if(qtyValue > 1){
                qtyElement.val(qtyValue - 1);
                updateQuantity(product_id, qtyElement.val());
            }else{
                remove(product_id);
            }
        });

        function remove(id){
            $.ajax({
                url: '{{route("remove-cart")}}',
                type: 'post',
                data: {product_id: id},
                dataType: 'json',
                success: function(response){
                    window.location.href = "{{route('cart')}}";
                }
            });
        }

        function updateQuantity(id, qty){
            $.ajax({
                url: '{{route("update-cart")}}',
                type: 'post',
                data: {
                    product_id: id,
                    quantity: qty
                },
                dataType: 'json',
                success: function(response){
                    window.location.href = "{{route('cart')}}";
                }
            });
        }
    </script>
@endsection