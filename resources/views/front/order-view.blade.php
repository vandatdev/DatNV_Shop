@extends('front.layouts.app')

@section('title')
    Orders View
@endsection

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('user.orders')}}">Orders</a></li>
                    <li class="breadcrumb-item">Orders View</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <div class="card">
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Product Name</th>
                                <th width="20%">Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($order_items))
                                <td colspan="5">Empty Order</td>
                            @else
                                @foreach ($order_items as $key => $item)
                                    @php
                                        $product = $item->product
                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$product->title}}</td>
                                        <td><img src="{{asset('uploads/products/'.$product->image)}}" alt=""></td>
                                        <td>{{$item->quantity}}</td>
                                        <td>${{$item->unit_price}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>										
                </div>
            </div>
        </div>
    </section>
@endsection
