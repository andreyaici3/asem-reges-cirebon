<?php

use App\Models\MasterProduk;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTransactionDetailTable extends Migration
{
    public function up()
    {
        Schema::create('customer_transaction_detail', function (Blueprint $table) {
            $table->unsignedBigInteger("transaction_id");
            $table->foreign("transaction_id")->references('id')->on('customer_transaction')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignIdFor(MasterProduk::class, "product_master_code")->constrained("product_master", "code");
            $table->double("price")->nullable();
            $table->double("selling")->nullable();
            $table->integer("qty")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_transaction_detail');
    }
}
