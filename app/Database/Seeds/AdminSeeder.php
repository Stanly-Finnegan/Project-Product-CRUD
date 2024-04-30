<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data =[
            'admin_uuid' => Uuid::uuid4(),
            'admin_email' => 'admin@gmail.com',
            'admin_password' => password_hash('123', PASSWORD_BCRYPT),
            'admin_name' => 'Admin',
            'admin_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
            'deleted_at' => null
        ];

        $this->db->table('admin_ms')->insert($data);
    }
}
