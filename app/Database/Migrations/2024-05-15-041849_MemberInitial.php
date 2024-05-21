<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'member_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'member_uuid' => [
                'type'              => 'CHAR',
                'constraint'        => '36',
            ],
            'member_email' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'member_password' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'member_name' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'member_phone' => [
                'type'              => 'VARCHAR',
                'constraint'        => '15'
            ],
            'member_active' => [
                'type'              => 'Boolean',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('member_id', true);
        $this->forge->createTable('member_ms');
    }

    public function down()
    {
        $this->forge->dropTable('member_ms');
    }
}
