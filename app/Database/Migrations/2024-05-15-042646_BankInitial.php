<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BankInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bank_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'bank_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'bank_name' =>[
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'bank_account_number' =>[
                'type' => 'VARCHAR', 
                'constraint' => '20',
            ],
            'bank_order' =>[
                'type' => 'INT',
            ],
            'bank_show' =>[
                'type' => 'BOOLEAN',
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
        $this->forge->addKey('bank_id', true);
        $this->forge->createTable('bank_ms');
    }

    public function down()
    {
        $this->forge->dropTable('bank_ms');
    }
}
