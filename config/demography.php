<?php

return [
    // Pilihan enum untuk form & validasi
    'education_levels' => ['tidak_sekolah','sd','smp','sma','d1','d2','d3','d4','s1','s2','s3'],
    'religions'        => ['islam','protestan','katolik','hindu','buddha','konghucu','kepercayaan'],
    'marital_statuses' => ['belum_kawin','kawin','cerai_hidup','cerai_mati'],
    'income_brackets'  => ['<1jt','1-3jt','3-5jt','>5jt'],
    'blood_types'      => ['A','B','AB','O'],
    'citizenships'     => ['WNI','WNA'],

    // Mapping label singkat (opsional)
    'gender_labels' => [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ],

    // Batasan kelompok umur (opsional, untuk chart)
    'age_bands' => [
        ['label' => '0–5',   'min' => 0,  'max' => 5],
        ['label' => '6–12',  'min' => 6,  'max' => 12],
        ['label' => '13–17', 'min' => 13, 'max' => 17],
        ['label' => '18–59', 'min' => 18, 'max' => 59],
        ['label' => '60+',   'min' => 60, 'max' => null],
    ],
];
