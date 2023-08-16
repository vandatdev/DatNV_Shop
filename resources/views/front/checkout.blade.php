@extends('front.layouts.app')

@section('title')
    Checkout
@endsection

@section('content')
    
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('cart')}}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form action="" method="post" id="orderForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="First Name" value="{{$user->name}}">
                                        <p class="error"></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{$user->email}}">
                                        <p class="error"></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country_code" id="country_code" class="form-control">
                                            <option selected disabled>Select a Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->code}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <p class="error"></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control"></textarea>
                                        <p class="error"></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City">
                                        <p class="error"></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State">
                                    </div>            
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip">
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Mobile No." value="{{$user->phone}}">
                                        <p class="error"></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>            
                                </div>
    
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach ($products as $product)
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$product->title}} x {{$cartItems[$product->id]['quantity']}}</div>
                                    <div class="h6">${{$product->price}}</div>
                                </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{$total}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>${{$total}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form">                        
                        <h3 class="card-title h5 mb-3">Payment Method</h3>
                        <div class="mb-1">
                            <input type="radio" name="payment_method" id="payment_method_cod" checked value="cod">
                            <label for="payment_method" class="form-check-lable">COD</label>
                        </div>
                        <div class="mb-1">
                            <input type="radio" name="payment_method" id="payment_method_stripe" value="stripe">
                            <label for="payment_method" class="form-check-lable">Stripe</label>
                        </div>
                        <div class="card-body p-0 d-none" id="cart-payment-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>                  
                    </div>
    
                          
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('js')
    <script>
        $('#payment_method_cod').click(function(){
            if($(this).is(":checked") == true){
                $('#cart-payment-form').addClass('d-none');
            }
        });

        $('#payment_method_stripe').click(function(){
            if($(this).is(":checked") == true){
                $('#cart-payment-form').removeClass('d-none');
            }
        });

        $('#orderForm').submit(function(event){
            event.preventDefault();

            $.ajax({
                url: '{{route("user.checkout")}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    var errors = response.errors;

                    if(response['status']){
                        console.log('Well Done!');
                        window.location.href = "{{route('user.thankyou')}}";

                    }else{
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select").removeClass('is-invalid');

                        $.each(errors, function(key, value){
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                        });
                    };
                },
            });
        });
    </script>
@endsection