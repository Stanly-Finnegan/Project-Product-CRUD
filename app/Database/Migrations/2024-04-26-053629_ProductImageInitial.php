<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductImageInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_image_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'product_image_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'product_image' =>[
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'product_image_order' =>[
                'type' => 'BIGINT',
            ],
            'product_image_show' =>[
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
        $this->forge->addKey('product_image_id',true);
        $this->forge->createTable('product_image_ms');
    }

    public function down()
    {
        $this->forge->dropTable('product_image_ms');
    }
}
