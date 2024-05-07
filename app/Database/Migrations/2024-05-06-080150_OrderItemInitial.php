<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderItemInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,                
            ],
            'product_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,                
            ],
            'order_item_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
                
            ],
            'order_item_quantity' =>[
                'type' => 'BIGINT',
                'unsigned' => true,                
            ],
            'order_item_total_price' =>[
                'type' => 'DOUBLE',                
            ],
            'created_at' =>[
                'type' => 'BIGINT',
                'null' => true,
                
            ],
            'updated_at' =>[
                'type' => 'BIGINT',
                'null' => true,
                
            ],
            'deleted_at' =>[
                'type' => 'BIGINT',
                'null' => true,
                
            ]
        ]);
        $this->forge->addKey('order_item_id', true);
        $this->forge->createTable('order_item_ms');
    }

    public function down()
    {
        $this->forge->dropTable('order_item_ms');
    }
}
