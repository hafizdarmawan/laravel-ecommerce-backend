<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->paginate(5);
        // return $sliders;
        return view('admin.slider.index',compact('sliders'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'      => 'required'
        ]);

        // upload image
        $image  = $request->file('image');
        $image->storeAs('public/sliders',$image->hashName());

        // save to DB
        $slider = Slider::create([
            'image'     => $image->hashName(),
            'link'      => $request->link
        ]);

        if($slider){
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function destroy($id){
        $slider = Slider::findOrFail($id);
        
        // hapus image
        $image = Storage::disk('local')->delete('public/sliders/'.$slider->image);
        $slider->delete();

        if($slider){
            return response([
                'status'    => 'success'
            ]);
        }else{
            return response([
                'status'    => 'error'
            ]);
        }
    }
}
