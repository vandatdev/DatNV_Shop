@extends('front.layouts.app')

@section('title')
    Orders
@endsection

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('home')}}">Home</a></li>
                    {{-- <li class="breadcrumb-item"><a class="white-text" href="{{route('cart')}}">Shop</a></li> --}}
                    <li class="breadcrumb-item">Orders</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <h5>Found: {{$count}} orders</h5>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($orders))
                                <td colspan="5">Empty Orders</td>
                            @else
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>${{$order->total_price}}</td>
                                        <td>{{$order->status}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td><a href="{{route('user.orders-view', $order->id)}}">View</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    
                </div>
            </div>
        </div>
    </section>
@endsection
