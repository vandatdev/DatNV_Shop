@extends('admin.layouts.app')

@section('title')
    List Orders
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><h5>Found: {{$count}} orders</h5></div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
        
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th>Created At</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <?php $customer = $order->user ?>
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$order->status}}</td>
                                    <td>$<b>{{$order->total_price}}</b></td>
                                    <td>{{$order->created_at}}</td>
                                    <td><a href="">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
			
@endsection
