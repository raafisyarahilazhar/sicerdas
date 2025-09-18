<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rt;

class RtSeeder extends Seeder
{
    public function run(): void
    {
        // Untuk tiap RW, buat 2 RT
        foreach (range(1, 3) as $rwId) {
            for ($i = 1; $i <= 2; $i++) {
                Rt::create([
                    'name' => "RT 0$rwId$i",
                    'rw_id' => $rwId,
                ]);
            }
        }
    }
}
