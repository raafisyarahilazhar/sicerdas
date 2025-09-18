<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rw;

class RwSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Rw::create([
                'name' => "RW 0$i",
            ]);
        }
    }
}
