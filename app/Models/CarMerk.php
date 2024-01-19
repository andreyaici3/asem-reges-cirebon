<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarMerk extends Model
{
    use HasFactory;
    protected $table = "car_merk";

    protected $fillable = ["name", "chief_id"];

    public function tipe(){
        return $this->hasMany(CarType::class, "merk_id");
    }
}
