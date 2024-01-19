<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $table = "product_type";

    protected $fillable = ["product_merk_id", "name"];

    public function merk(){
        return $this->belongsTo(ProductMerk::class, "product_merk_id");
    }
}
