<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class OrangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
            'nama'          => 'Awen',
            'alamat'        => 'Baruga, Kendari',
            'created_at'    => Time::now(),
            'updated_at'    => Time::now()
            ],
            [
            'nama'          => 'Rifan hidayat',
            'alamat'        => 'Home pis, Baruga',
            'created_at'    => Time::now(),
            'updated_at'    => Time::now()
            ],
                        [
            'nama'          => 'Muhammad Luthfi',
            'alamat'        => 'BTN Regency, Anduonohu',
            'created_at'    => Time::now(),
            'updated_at'    => Time::now()
            ]
        ];

        // Simple Queries
        // $this->db->query(
        //     'INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)',
        //     $data);

        // Using Query Builder
        // Per satu data
        // $this->db->table('orang')->insert($data);
        // Per Batch
        $this->db->table('orang')->insertBatch($data);

    }
}