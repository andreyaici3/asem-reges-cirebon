<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "customer_transaction";

    protected $fillable = ["customer_id", "description", "total_price", "total_selling", "price_service", "total_purchased", "total_item", "role", "mekanik_id", "kasir_id", "status", "chief_id"];

    public function mekanik()
    {
        return $this->belongsTo(User::class, "mekanik_id");
    }

    public function detail(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function branch(){
        return $this->belongsTo(ChiefBranch::class, "chief_id");
    }

    public function customer(){
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function nota(){
        return $this->hasOne(Nota::class, 'transaction_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, "kasir_id");
    }
}
