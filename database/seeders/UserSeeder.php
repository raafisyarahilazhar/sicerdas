<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Resident;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin & Operator ----
        User::updateOrCreate(
            ['email' => 'admin@desa.com'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'rw_id' => null,
                'rt_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'operator@desa.com'],
            [
                'name' => 'Operator Desa',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'rw_id' => null,
                'rt_id' => null,
            ]
        );

        // ---- Kades ----
        User::updateOrCreate(
            ['email' => 'kades@desa.com'],
            [
                'name' => 'Kepala Desa',
                'password' => Hash::make('password'),
                'role' => 'kades',
                'rw_id' => null,
                'rt_id' => null,
            ]
        );

        // ---- RW ----
        User::updateOrCreate(
            ['email' => 'rw1@desa.com'],
            [
                'name' => 'Ketua RW 1',
                'password' => Hash::make('password'),
                'role' => 'rw',
                'rw_id' => 1,
                'rt_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rw2@desa.com'],
            [
                'name' => 'Ketua RW 2',
                'password' => Hash::make('password'),
                'role' => 'rw',
                'rw_id' => 2,
                'rt_id' => null,
            ]
        );

        // ---- RT ----
        User::updateOrCreate(
            ['email' => 'rt1_rw1@desa.com'],
            [
                'name' => 'Ketua RT 1 RW 1',
                'password' => Hash::make('password'),
                'role' => 'rt',
                'rw_id' => 1,
                'rt_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt2_rw1@desa.com'],
            [
                'name' => 'Ketua RT 2 RW 1',
                'password' => Hash::make('password'),
                'role' => 'rt',
                'rw_id' => 1,
                'rt_id' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt1_rw2@desa.com'],
            [
                'name' => 'Ketua RT 1 RW 2',
                'password' => Hash::make('password'),
                'role' => 'rt',
                'rw_id' => 2,
                'rt_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt2_rw2@desa.com'],
            [
                'name' => 'Ketua RT 2 RW 2',
                'password' => Hash::make('password'),
                'role' => 'rt',
                'rw_id' => 2,
                'rt_id' => 2,
            ]
        );

        // ---- WARGA + RESIDENT ----
        $warga1 = User::updateOrCreate(
            ['email' => 'warga_rt1_rw1@desa.com'],
            [
                'name' => 'Warga RT1 RW1',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'rw_id' => 1,
                'rt_id' => 1,
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '32010001'],
            [
                'user_id' => $warga1->id,
                'name' => 'Warga RT1 RW1',
                'address' => 'Alamat Warga RT1 RW1',
                'rw_id' => 1,
                'rt_id' => 1,
            ]
        );

        $warga2 = User::updateOrCreate(
            ['email' => 'warga_rt2_rw1@desa.com'],
            [
                'name' => 'Warga RT2 RW1',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'rw_id' => 1,
                'rt_id' => 2,
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '32010002'],
            [
                'user_id' => $warga2->id,
                'name' => 'Warga RT2 RW1',
                'address' => 'Alamat Warga RT2 RW1',
                'rw_id' => 1,
                'rt_id' => 2,
            ]
        );

        $warga3 = User::updateOrCreate(
            ['email' => 'warga_rt1_rw2@desa.com'],
            [
                'name' => 'Warga RT1 RW2',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'rw_id' => 2,
                'rt_id' => 1,
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '32020001'],
            [
                'user_id' => $warga3->id,
                'name' => 'Warga RT1 RW2',
                'address' => 'Alamat Warga RT1 RW2',
                'rw_id' => 2,
                'rt_id' => 1,
            ]
        );

        $warga4 = User::updateOrCreate(
            ['email' => 'warga_rt2_rw2@desa.com'],
            [
                'name' => 'Warga RT2 RW2',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'rw_id' => 2,
                'rt_id' => 2,
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '32020002'],
            [
                'user_id' => $warga4->id,
                'name' => 'Warga RT2 RW2',
                'address' => 'Alamat Warga RT2 RW2',
                'rw_id' => 2,
                'rt_id' => 2,
            ]
        );
    }
}
