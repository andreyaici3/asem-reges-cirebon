<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStokToProductMasterTable extends Migration
{
   
    public function up()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->integer("stok")->after("selling")->default(0);
        });
    }

    
    public function down()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->dropColumn("stok");
        });
    }
}
