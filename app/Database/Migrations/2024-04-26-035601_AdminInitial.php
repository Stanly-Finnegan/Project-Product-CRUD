<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdminInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'admin_id' => [
                'type'              => 'BIGINT',
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'admin_uuid' => [
                'type'              => 'CHAR',
                'constraint'        => '225',
            ],
            'admin_email' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'admin_password' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'admin_name' => [
                'type'              => 'VARCHAR',
                'constraint'        => '225',
            ],
            'admin_active' => [
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
        $this->forge->addKey( 'admin_id', true );
        $this->forge->createTable('admin_ms');
    }

    public function down()
    {
        $this->forge->dropTable( 'admin_ms' );
    }
}
