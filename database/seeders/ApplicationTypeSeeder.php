<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationType;

class ApplicationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Surat Keterangan Domisili',
                // HAPUS json_encode(), berikan array PHP langsung
                'requirements' => [
                    ["name" => "nama_pemohon", "label" => "Nama Pemohon", "type" => "text", "required" => true],
                    ["name" => "alamat", "label" => "Alamat", "type" => "text", "required" => true],
                    ["name" => "kk", "label" => "Upload Kartu Keluarga", "type" => "file", "required" => true],
                ],
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'requirements' => [
                    ["name" => "nama_anak", "label" => "Nama Anak", "type" => "text", "required" => true],
                    ["name" => "tanggal_lahir", "label" => "Tanggal Lahir", "type" => "date", "required" => true],
                    ["name" => "akta", "label" => "Upload Akta Kelahiran", "type" => "file", "required" => true],
                ],
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'requirements' => [
                    ["name" => "nama_almarhum", "label" => "Nama Almarhum", "type" => "text", "required" => true],
                    ["name" => "tanggal_meninggal", "label" => "Tanggal Meninggal", "type" => "date", "required" => true],
                    ["name" => "surat_rumah_sakit", "label" => "Surat Keterangan Rumah Sakit", "type" => "file", "required" => false],
                ],
            ],
            [
                'name' => 'Surat Pengantar Pembuatan KTP',
                'requirements' => [
                    ["name" => "nama_pemohon", "label" => "Nama Pemohon", "type" => "text", "required" => true],
                    ["name" => "nik", "label" => "NIK", "type" => "text", "required" => true],
                    ["name" => "kk", "label" => "Upload Kartu Keluarga", "type" => "file", "required" => true],
                ],
            ],
        ];

        foreach ($types as $type) {
            ApplicationType::updateOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}