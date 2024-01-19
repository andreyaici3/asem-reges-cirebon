<?php

use App\Models\ProductMerk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypeTable extends Migration
{
    public function up()
    {
        Schema::create('product_type', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductMerk::class, "product_merk_id")->constrained("product_merk");
            $table->string("name");
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
        Schema::dropIfExists('product_type');
    }
}
