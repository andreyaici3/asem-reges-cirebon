<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = "employe";
    protected $fillable = ["users_id", "chief_id"];

    public function branch(){
        return $this->hasOne(ChiefBranch::class, "users_id");
    }
}
