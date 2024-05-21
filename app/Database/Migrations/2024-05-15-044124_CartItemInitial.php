<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartItemInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cart_item_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'cart_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'cart_item_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'cart_item_quantity' =>[
                'type' => 'BIGINT',
            ],
            'cart_item_price' =>[
                'type' => 'DOUBLE',
            ],
            'cart_item_total_price' =>[
                'type' => 'DOUBLE',
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
        $this->forge->addKey('cart_item_id', true);
        $this->forge->createTable('cart_item_ms');
    }

    public function down()
    {
        $this->forge->dropTable('cart_item_ms');
    }
}
