<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use DateTime;

class OrderInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_uuid' =>[
                'type' => 'CHAR',
                'constraint'=> '36',
            ],
            'order_number' =>[
                'type' => 'VARCHAR',
                'constraint'=> '100',
            ],
            'order_total_price' =>[
                'type' => 'DOUBLE',
            ],
            'order_status' =>[
                'type' => 'INT',
            ],
            'created_at' =>[
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' =>[
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' =>[
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('order_id', true);
        $this->forge->createTable('order_ms');
    }

    public function down()
    {
        $this->forge->dropTable('order_ms');
    }
}
