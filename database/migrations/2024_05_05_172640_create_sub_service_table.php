<?php

use App\Models\CarType;
use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Service::class, "service_id")->constrained("service");
            $table->foreignIdFor(CarType::class, "id_type")->constrained("car_type");
            $table->double("harga_jasa")->default(0);
            $table->double("harga_jasa_khusus")->default(0);
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
        Schema::dropIfExists('sub_service');
    }
}
