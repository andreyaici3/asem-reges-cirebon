<?php

use App\Models\ChiefBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMerkTable extends Migration
{
    public function up()
    {
        Schema::create('product_merk', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->string("name");
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('product_merk');
    }
}
