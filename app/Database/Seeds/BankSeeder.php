<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class BankSeeder extends Seeder
{
    public function run()
    {
        $data =[
            'bank_uuid' => Uuid::uuid4(),
            'bank_name' => 'BCA',
            'bank_account_number' => '123456789',
            'bank_order' => 1,
            'bank_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
            'deleted_at' => null,
        ];

        $this->db->table('bank_ms')->insert($data);

    }
}
