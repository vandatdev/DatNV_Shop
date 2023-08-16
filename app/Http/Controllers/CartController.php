<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(){
        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $total = Cart::getTotalPrice();

        return view('front.cart', compact('cartItems', 'products', 'total'));
    }

    public function addToCart(Request $request){
        $product_id = $request->id;
        $product = Product::find($product_id);
        
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
        if ($user) {

            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            } else {
                $data = [
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ];
                CartItem::create($data);
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $productFound = false;
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }
            if (!$productFound) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function remove(Request $request)
    {
        $user = $request->user();
        $product_id = (int)$request->product_id;
        if ($user) {
            $cartItem = CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product_id])->first();
            if ($cartItem) {
                $cartItem->delete();
            }

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product_id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function updateQuantity(Request $request)
    {
        $user = $request->user();
        $product_id = (int)$request->product_id;
        $quantity = (int)$request->quantity;

        if ($user) {
            CartItem::where(['user_id' => $request->user()->id, 'product_id' => $product_id])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => $item) {
                if ($item['product_id'] === $product_id) {
                    $cartItems[$i]['quantity'] = $quantity;
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function checkout(Request $request)
    {
        if(Cart::getCartItemsCount() == 0){
            return redirect()->route('cart');
        }
        $user = $request->user();

        if($user == null){
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('user.login');
        }
        session()->forget('url.intended');

        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $total = Cart::getTotalPrice();
        $countries = Country::orderBy('name', 'ASC')->get();

        return view('front.checkout', compact('products', 'cartItems', 'user', 'total', 'countries'));
    }
}
