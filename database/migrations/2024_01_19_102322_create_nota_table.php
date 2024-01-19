<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTable extends Migration
{
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transaction_id");
            $table->foreign("transaction_id")->references('id')->on('customer_transaction')->onDelete("cascade")->onUpdate("cascade");
            $table->double('total_payment');
            $table->double('payment_amount');
            $table->double('change_money');
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('nota');
    }
}
