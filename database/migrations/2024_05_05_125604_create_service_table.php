<?php

use App\Models\CarType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{

    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string("service_name");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service');
    }
}
