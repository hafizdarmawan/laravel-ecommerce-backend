<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->get();
        return response()->json([
            'success'     => true,
            'message'     => 'List Data Sliders',
            'sliders'     => $sliders  
        ]);
    }
}
