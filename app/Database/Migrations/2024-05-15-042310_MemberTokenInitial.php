<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberTokenInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'member_token_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'member_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'member_token_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'created_at' =>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' =>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' =>[
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('member_token_id', true);
        $this->forge->createTable('member_token_trs');

    }

    public function down()
    {
        $this->forge->dropTable('member_token_trs');
    }
}
