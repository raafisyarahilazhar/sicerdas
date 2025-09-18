<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RwSeeder::class,
            RtSeeder::class,
            UserSeeder::class,
            ApplicationTypeSeeder::class,
        ]);
    }
}
