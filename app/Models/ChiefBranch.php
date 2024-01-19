<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiefBranch extends Model
{
    use HasFactory;

    protected $table = "chief_branch";
    protected $fillable = ["users_id", "branch_id"];

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, "branch_id");
    }
}
