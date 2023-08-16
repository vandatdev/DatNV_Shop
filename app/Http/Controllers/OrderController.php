<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()
            ->where(['created_by' => $user->id])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $count = Order::where('created_by', $user->id)->count();
        return view('front.order', compact('orders', 'count'));
    }

    public function view($order_id)
    {
        $user = \request()->user();
        $order = Order::find($order_id);
        $order_items = OrderItem::where('order_id', $order_id)->with('product')->get();
        
        if ($order->created_by !== $user->id) {
            return response("You don't have permission to view this order", 403);
        }

        return view('front.order-view', compact('order_items'));
    }
}
