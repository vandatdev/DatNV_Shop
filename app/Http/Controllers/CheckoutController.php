<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Helpers\Cart;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'name' => 'required',
            'email' => 'required',
            'country_code' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = $request->user();
        $data['user_id'] = $user->id;
        Address::updateOrCreate(['user_id' => $user->id], $data);

        [$products, $cartItems] = Cart::getProductsAndCartItems();
        $orderItems = [];
        $totalPrice = 0;

        foreach ($products as $product) {
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price
            ];
        }

        if($data['payment_method'] == 'cod'){ // PAYMENT COD METHOD
            // Create Order
            $orderData = [
                'total_price' => $totalPrice,
                'status' => OrderStatus::Unpaid,
                'created_by' => $user->id,
            ];
            $order = Order::create($orderData);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                OrderItem::create($orderItem);
            }

            // Create Payment
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'status' => 'pending',
                'type' => 'cc',
                'created_by' => $user->id,
                // 'session_id' => $session->id
            ];
            Payment::create($paymentData);
            CartItem::where(['user_id' => $user->id])->delete();

            session()->flash('success', 'Order saved successfully');
            return response()->json([
                'status' => true,
                'orderId' => $order->id,
                'message' => 'Order saved successfully',
            ]);
        }else{ // PAYMENT STRIPE METHOD
            return request()->json([
                'message' => 'error',
                'status' => false,
            ]);
        }
    }
     
    
    public function thankyou(){
        return view('front.thankyou');
    }
}
