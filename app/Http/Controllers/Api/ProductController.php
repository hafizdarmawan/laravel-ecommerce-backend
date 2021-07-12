<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->get();
        return response()->json([
            'success'   => true,
            'maessage'  => 'List Data Product',
            'products'  => $products
        ], 200);
    }

    public function show($slug){
        $product = Product::where('slug',$slug)->first();
        if($product){
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Data Product',
                'product'   => $product
            ], 200);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Data Product Tidak Ditemukan'
            ], 404);
        }
    }
}
