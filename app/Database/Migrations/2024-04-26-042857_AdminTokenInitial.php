<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdminTokenInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'admin_token_id' =>  [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'admin_id' => [
                'type' => 'BIGINT',     
                'unsigned' => true           
            ],
            'admin_token_uuid' => [
                'type' => 'CHAR',
                'constraint' => '36',
                'null' => false
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
        $this->forge->addKey('admin_token_id', true);
        $this->forge->createTable('admin_token_trs');
    }

    public function down()
    {
        $this->forge->dropTable('admin_token_trs');   
    }
}
