<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at', 'DESC')->with('user')->paginate(10);
        $count = Order::count();
        
        return view('admin.order', compact('orders', 'count'));
    }
}
