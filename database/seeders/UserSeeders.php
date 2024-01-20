<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => "Andrey Andriansyah",
                'email' => "andreyandri90@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("password"),
                "role" => "superuser",
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "AA Yana Maulana Akbar.",
                'email' => "yannaakbar@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("password"),
                "role" => "superadmin",
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Superadmin Account",
                'email' => "superadmin@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("superadmin"),
                'remember_token' => Str::random(10),
                "role" => "superadmin",
            ],
            [
                'name' => "Administrator Account",
                'email' => "admin@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("admin"),
                'remember_token' => Str::random(10),
                "role" => "admin",
            ],
            [
                'name' => "Kasir Account",
                'email' => "kasir@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("kasir"),
                'remember_token' => Str::random(10),
                "role" => "kasir",
            ],
            [
                'name' => "Mekanik Account",
                'email' => "mekanik@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("mekanik"),
                'remember_token' => Str::random(10),
                "role" => "mekanik",
            ],
            [
                'name' => "Gudang Account",
                'email' => "gudang@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make("gudang"),
                'remember_token' => Str::random(10),
                "role" => "gudang",
            ],
        ])->each(function ($user) {
            User::create($user);
        });
    }
}
