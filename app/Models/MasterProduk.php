<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduk extends Model
{
    use HasFactory;

    protected $table = "product_master";
    protected $fillable = ["chief_id", "code","price", "name", "price", "selling", "product_type_id", "vendor_id", "stok"];

    public function available(){
        return $this->hasMany(AvailableProduct::class, 'product_master_code', 'code');
    }

    public function tipe_produk(){
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, "vendor_id");
    }
}
