<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $table = "sub_service";

    protected $fillable = ["service_id", "id_type", "harga_jasa", "harga_jasa_khusus"];

    public function jenis()
    {
        return $this->belongsTo(CarType::class, "id_type");
    }
}
