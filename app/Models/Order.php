<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // fillabel digunakan untuk memberikan izin agar field-field 
    // dapat melakukan manipulasi data, seperti menambah data,
    // edit, update dan juga delete
    protected $fillable = [
        'invoice_id','invoice','product_id','product_name','image','qty','price'
    ];


    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
