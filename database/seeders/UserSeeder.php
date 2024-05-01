<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// UserSeeder.php


class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(10)->create();
    }
}
