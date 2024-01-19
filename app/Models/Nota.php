<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = "nota";
    protected $fillable = ["transaction_id", "total_payment", "payment_amount", "change_money"];

    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, "transaction_id");
    }
}
