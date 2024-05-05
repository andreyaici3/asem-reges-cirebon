<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $table = "car_type";

    protected $fillable = ["merk_id","jenis", "tipe", "tahun"];

    public function merk(){
        return $this->belongsTo(CarMerk::class, "merk_id");
    }
}
