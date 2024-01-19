<?php

use App\Models\ChiefBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTable extends Migration
{
    public function up()
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->string("name");
            $table->text("address")->nullable();
            $table->bigInteger("phone");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor');
    }
}
