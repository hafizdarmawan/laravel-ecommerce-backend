<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // fillabel digunakan untuk memberikan izin agar field-field 
    // dapat melakukan manipulasi data, seperti menambah data,
    // edit, update dan juga delete
    protected $fillable = [
        'name','slug','image'
    ];

    // getImageAtribute akan digunakan untuk mendapatkan 
    // full-path/ URL dari image yang ada pada categories
    public function getImageAtribute($image){
        return asset('storage/categories/'.$image);
    }

    // one to many
    public function products(){
        return $this->hasMany(Product::class);
    }
}
