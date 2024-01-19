<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = "customer_transaction_detail";

    protected $fillable = ["transaction_id", "product_master_code", "price", "selling", "qty"];

    public function produk(){
        return $this->belongsTo(MasterProduk::class, "product_master_code", "code");
    }

    public function transaksi(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
