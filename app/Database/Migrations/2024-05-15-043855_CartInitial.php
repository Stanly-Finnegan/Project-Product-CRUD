<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cart_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'member_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'cart_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'cart_total_price' =>[
                'type' => 'DOUBLE',
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
        $this->forge->addKey('cart_id', true);
        $this->forge->createTable('cart_ms');
    }

    public function down()
    {
        $this->forge->dropTable('cart_ms');
    }
}
