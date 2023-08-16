<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $products = Product::latest()->get();
        
        return view('front.home', compact('products'));
    }
}
