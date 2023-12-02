<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->create();
    }


}
