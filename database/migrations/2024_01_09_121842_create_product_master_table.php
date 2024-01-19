<?php

use App\Models\ChiefBranch;
use App\Models\ProductType;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMasterTable extends Migration
{
    public function up()
    {
        Schema::create('product_master', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ChiefBranch::class, "chief_id")->constrained("chief_branch");
            $table->foreignIdFor(ProductType::class, "product_type_id")->constrained("product_type");
            $table->foreignIdFor(Vendor::class, "vendor_id")->constrained("vendor");
            $table->unsignedBigInteger("code")->unique();
            $table->string("name");
            $table->bigInteger("price");
            $table->bigInteger("selling");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_master');
    }
}
