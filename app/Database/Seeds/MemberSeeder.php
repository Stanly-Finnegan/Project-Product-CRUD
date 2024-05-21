<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'member_uuid' => Uuid::uuid4(),
            'member_email' => 'firstMember@gmail.com',
            'member_password' => password_hash('123',PASSWORD_BCRYPT),
            'member_name' => 'First Member',
            'member_phone' => '081234567890',
            'member_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
            'deleted_at' => null
        ];

        $this->db->table('member_ms')->insert($data);
    }
}
