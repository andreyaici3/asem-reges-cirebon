<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ["name", "address", "phone"];

    public function chief(){
        return $this->hasOne(ChiefBranch::class);
    }
}
