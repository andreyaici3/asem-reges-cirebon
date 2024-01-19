<?php

use App\Models\CarType;
use App\Models\MasterProduk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableProductTable extends Migration
{
    public function up()
    {
        Schema::create('available_product', function (Blueprint $table) {
            // $table->id();
            $table->foreignIdFor(MasterProduk::class, "product_master_code")->constrained("product_master", "code");
            $table->foreignIdFor(CarType::class, "car_type_id")->constrained("car_type");   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_product');
    }
}
