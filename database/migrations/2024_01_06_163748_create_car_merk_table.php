<?php

use App\Models\ChiefBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarMerkTable extends Migration
{
    public function up()
    {
        Schema::create('car_merk', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_merk');
    }
}
