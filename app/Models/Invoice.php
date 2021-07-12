<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

     // fillabel digunakan untuk memberikan izin agar field-field 
    // dapat melakukan manipulasi data, seperti menambah data,
    // edit, update dan juga delete
    protected $fillable = [
        'invoice','customer_id','courier','service','cost_courier','weight','name','phone',
        'province','city','address','status','snap_token','grand_total'
    ];


    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
