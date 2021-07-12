<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /** 
     * Index
     * 
    */
    public function index(){
        $categories = Category::latest()->when(request()->q, function($categories){
            $categories = $categories->where('name','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.category.index',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name'  => 'required|unique:categories'
        ]);

        // upload Image
        $image  = $request->file('image');
        $image  ->storeAs('public/categories',$image->hashName());

        // Upload Image
        $category   = Category::create([
            'image' => $image->hashName(),
            'name'  => $request->name,
            'slug'  => Str::slug($request->name)
        ]);

        // jika kategori true
        if($category){
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil disimpan']);
        }else{
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    // edit
    public function edit(Category $category){
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request, Category $category){
        // update
        $this->validate($request,[
            'name'  => 'required|unique:categories,name,'.$category->id
        ]);

        // jika image kosong
        if($request->file('image') == ''){
            // update data tanpa image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name'  => $request->name,
                'slug'  => Str::slug($request->name,'-')
            ]);
        }else{
            // hapus image lama
            Storage::disk('local')->delete('public/categories/'.$category->image);
            
            // upload image baru
            $image  = $request->file('image');
            $image  -> storeAs('public/categories',$image->hashName());

            // update dengan image baru
            $category   = Category::findOrFail($category->id);
            $category   ->update([
                'image' => $image->hashName(),
                'name'  => $request->name,
                'slug'  => Str::slug($request->name)
            ]);
        }
        // jika category true
         if($category){
            // redirect dengan pesan
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil diUpdate']);
        }else{
            // redirect dengan pesan error
            return redirect()->route('admin.category.index')->with(['error'=> 'Data Gagal Diupdate']);
        }
    }

    public function destroy($id){
        $category   = Category::findOrFail($id);
        $image      = Storage::disk('local')->delete('public/categories/'.$category->image);
        $category   ->delete();
         if($category){
            // redirect dengan pesan
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
