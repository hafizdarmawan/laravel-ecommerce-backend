<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(){
        $products = Product::latest()->when(request()->q,function($products){
            $products = $products->where('title','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.product.index',compact('products'));
    }

    public function create(){
        $categories = Category::latest()->get();
        return view('admin.product.create',compact('categories'));
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:products',
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required',
        ]);

        // upload image
        $image      = $request->file('image');
        $image      -> storeAs('public/products',$image->hashName());

        // simpan ke database
        $products = Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'slug'          => Str::slug($request->title,'-'),
            'category_id'   => $request->category_id,
            'content'       => $request->content,
            'unit'          => $request->unit,
            'weight'        => $request->weight,
            'price'         => $request->price,
            'discount'      => $request->discount,
            'keywords'      => $request->keywords,
            'description'   => $request->description
        ]);

        if($products){
            return redirect()->route('admin.product.index')->with('success','Berhasil Menambah Product');
        }else{
            return redirect()->route('admin.product.index')->with('error','Gagal Menambah Product');
        }
    }

    public function edit(Product $product){
        $categories = Category::latest()->get();
        return view('admin.product.edit',compact(['categories','product']));
    }

    public function update(Request $request, Product $product){
        $this->validate($request,[
            'title'         => 'required|unique:products,title,'.$product->id,
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required'
        ]);

        // dd($request);

        // jika image kosong
        if($request->file('image') == ''){
            $product = Product::findOrFail($product->id);
            $product->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title,'-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'weight'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
                'keywords'      => $request->keywords,
                'description'   => $request->description
            ]);
        }else{
            //hapus image lama
            Storage::disk('local')->delete('public/products/'.$product->image);
            
            // upload image baru
            $image = $request->file('image');
            $image ->storeAs('public/products',$image->hashName());

            // update data
            $product = Product::findOrFail($product->id);
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'slug'          => Str::slug($request->title,'-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'weight'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
                'keywords'      => $request->keywords,
                'description'   => $request->description
            ]);
        }

                    // jika products == true
            if($product){
                return redirect()->route('admin.product.index')->with('success','Berhasil Mengubah Data !');
            }else{
                return redirect()->route('admin.product.index')->with('error','Gagal Merubah Data');
            }
    }

    public function destroy($id){
        $product    = Product::findOrFail($id);
        $image      = Storage::disk('local')->delete('public/products/'.$product->image);
        $product->delete();

        if($product){
            return response()->json([
                'status'    => 'success'
            ]);
        }else{
            return response()->json([
                'status'    => 'error'
            ]);
        }
    }


}
