<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        collect([
            // [
            //     "service_name" => "Terot",
            // ],
            // [
            //     "service_name" => "Rack End",
            // ],
            // [
            //     "service_name" => "Ball Joint Lower",
            // ],
            // [
            //     "service_name" => "Ball Join Upper",
            // ],
            // [
            //     "service_name" => "Link Stabilizer",
            // ],
            // [
            //     "service_name" => "Pitman Arm",
            // ],
        ])->each(function($service){
            Service::create($service);
        });
    }
}
