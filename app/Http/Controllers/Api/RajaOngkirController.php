<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class RajaOngkirController extends Controller
{
    public function getProvinces(){
        $provinces = Province::all();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Provinces',
            'data'      => $provinces
        ]);
    }


    public function getCities(Request $request){
        $city = City::where('province_id',$request->province_id)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Cities By Province',
            'data'      => $city
        ]);
    }

    public function checkOngkir(Request $request){
        $cost = RajaOngkir::ongkosKirim([
            // ID KOTA/KABUPATEN ASAL
            'origin'     => 113,
            // kota/kabupaten tujuan
            'destination'=> $request->city_destination,
            // berat barang dalam gram
            'weight'     => $request->weight,
            // kode kurir pengiriman [jne,post,tiki]
            'courier'    => $request->courier 
        ])->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Cost All Courier'.$request->courier,
            'data'      => $cost
        ]); 
    }
}
