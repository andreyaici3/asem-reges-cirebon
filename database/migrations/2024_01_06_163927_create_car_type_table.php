<?php

use App\Models\CarMerk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTypeTable extends Migration
{
    public function up()
    {
        Schema::create('car_type', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CarMerk::class, "merk_id")->constrained("car_merk");
            $table->string("jenis");
            $table->string("tipe")->nullable()->default(null);
            $table->string("tahun")->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_type');
    }
}
