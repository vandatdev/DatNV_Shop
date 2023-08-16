<?php

use App\Models\Category;

function getCategories(){
    return Category::where('status', '1')->orderBy('name', 'ASC')->with('sub_category')->get();
}

function getAdminInfo(){
    $request = \request();
    $admin = $request->user();
    return $admin;
}
?>