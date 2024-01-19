<?php

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiefBranchTable extends Migration
{
    public function up()
    {
        Schema::create('chief_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'users_id')->unique()->nullable()->constrained('users');
            $table->foreignIdFor(Branch::class, 'branch_id')->unique()->nullable()->constrained('branches');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chief_branch');
    }
}
