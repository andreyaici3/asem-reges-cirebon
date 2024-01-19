<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMerk extends Model
{
    use HasFactory;
    protected $table = "product_merk";

    protected $fillable = ["chief_id", "name"];

    public function type(){
        return $this->hasMany(ProductType::class, "product_merk_id");
    }
}
