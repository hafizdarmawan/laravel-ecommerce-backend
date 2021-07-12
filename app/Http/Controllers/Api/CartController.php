<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');   
    }

    public function index(){
        $carts = Cart::with('product')
        ->where('customer_id',auth()->user()->id)
        ->orderBy('created_at','desc')
        ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Cart',
            'cart'      => $carts
        ]);
    }

    public function store(Request $request){
        $item = Cart::where('product_id',$request->product_id)
        ->where('customer_id',$request->customer_id);

        if($item->count()){
            // increment quantity
            $item->increment('quantity');
            $item = $item->first();
            // sum price * quantity (total)
            $price = $request->price * $item->quantity;
            //sum weght {Berat} 
            $weight = $request->weight * $item->quantity;
            $item->update([
                'price'     => $price,
                'weight'    => $weight
            ]);
        }else{
            $item = Cart::create([
                'product_id'    => $request->product_id,
                'customer_id'   => $request->customer_id,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'weight'        => $request->weight
            ]);
        }
        
        return response()->json([
            'success'       => true,
            'message'       => 'Success Add To Cart',
            'quantity'      => $item->quantity,
            'product'       => $item->product
        ]);
    }

    public function getCartTotal(){
        $carts = Cart::with('product')
        ->where('customer_id', auth()->user()->id)
        ->orderBy('created_at','desc')
        ->sum('price');

        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Price',
            'total'     => $carts
        ]);
    }


    public function getCartTotalWeight(){
        $carts = Cart::with('product')
        ->where('customer_id',auth()->user()->id)
        ->orderBy('created_at','desc')
        ->sum('weight');

        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Weight',
            'total'     => $carts
        ]);
    }

    public function removeCart(Request $request){
        Cart::with('product')
        ->whereId($request->cart_id)
        ->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Remove Item Cart'
        ]);
    }

    public function removeAllCart(Request $request){
        Cart::with('product')
        ->where('customer_id',auth()->guard('api')->user()->id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Removw All Item In Cart'
        ]);
    }


}
