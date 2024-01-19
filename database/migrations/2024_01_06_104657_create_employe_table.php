<?php

use App\Models\ChiefBranch;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
  
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
        Schema::dropIfExists('employe');
    }
}
