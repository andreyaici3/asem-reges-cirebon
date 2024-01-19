<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeders extends Seeder
{
    public function run()
    {
        collect([
            [
                "name" => "Cabang Kuningan",
                "address" => "Kuningan, Jabar",
                "phone" => 6289675677955,
            ]
        ])->each(function($branch){
            Branch::create($branch);
        });
    }
}
