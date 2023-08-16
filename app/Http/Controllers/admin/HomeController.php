<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $admin = Auth::guard('admin')->user();
        $order_count = Order::count();
        $customer = Order::get()->groupBy('created_by')->count();
        $totalIncome = Order::where('status', 'unpaid')->sum('total_price');

        return view('admin.dashboard', compact('order_count', 'customer', 'totalIncome'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
