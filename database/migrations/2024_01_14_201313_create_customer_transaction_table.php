<?php

use App\Models\ChiefBranch;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('customer_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class, "customer_id")->nullable()->constrained('customer');
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->string("description")->nullable();
            $table->double("total_price")->nullable();
            $table->double("total_selling")->nullable();
            $table->double("price_service")->nullable();
            $table->double("total_purchased");
            $table->integer("total_item");
            $table->enum("role", ["mekanik", "kasir"])->default("mekanik");
            $table->foreignIdFor(User::class, "mekanik_id")->nullable()->constrained("users");
            $table->foreignIdFor(User::class, "kasir_id")->nullable()->constrained("users");
            $table->enum("status", ["waiting", "paid", "unpaid", "canceled"])->default("waiting");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_transaction');
    }
}
