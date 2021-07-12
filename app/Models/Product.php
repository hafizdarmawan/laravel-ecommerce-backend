<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // fillabel digunakan untuk memberikan izin agar field-field 
    // dapat melakukan manipulasi data, seperti menambah data,
    // edit, update dan juga delete
    protected $fillable = [
        'image','title','slug','category_id','content','weight','price','discount'
    ];

     // getImageAtribute akan digunakan untuk mendapatkan 
    // full-path/ URL dari image yang ada pada categories

    public function getImageAtribute($image){
        return asset('storage/products/'.$image);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

}
