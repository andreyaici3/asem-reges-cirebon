<?php

use App\Models\CarType;
use App\Models\ChiefBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
   
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->foreignIdFor(CarType::class, "car_type_id")->constrained("car_type");
            $table->string("name");
            $table->string("number_plat");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
