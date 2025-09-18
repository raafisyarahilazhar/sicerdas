<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        $residents = [
            ['name' => 'Warga A', 'nik' => '32010001', 'address' => 'Alamat A', 'rw_id' => 1, 'rt_id' => 1],
            ['name' => 'Warga B', 'nik' => '32010002', 'address' => 'Alamat B', 'rw_id' => 1, 'rt_id' => 2],
            ['name' => 'Warga C', 'nik' => '32020001', 'address' => 'Alamat C', 'rw_id' => 2, 'rt_id' => 1],
            ['name' => 'Warga D', 'nik' => '32020002', 'address' => 'Alamat D', 'rw_id' => 2, 'rt_id' => 2],
        ];

        foreach ($residents as $resident) {
            Resident::updateOrCreate(
                ['nik' => $resident['nik']],
                $resident
            );
        }
    }
}
