<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableProduct extends Model
{
    use HasFactory;

    protected $table = "available_product";

    protected $fillable = ["product_master_code", "car_type_id"];

    public function tipe(){
        return $this->hasOne(CarType::class, 'id', 'car_type_id');
    }
    
}
