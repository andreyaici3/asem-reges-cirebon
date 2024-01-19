<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customer";

    protected $fillable = ["chief_id", "car_type_id", "name", "number_plat"];

    public function chief(){
        return $this->belongsTo(ChiefBranch::class, "chief_id");
    }

    public function tipe_mobil(){
        return $this->belongsTo(CarType::class, "car_type_id");
    }

    public function transaksi()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
}
