<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id'=> [
                'type' => 'BIGINT',
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'product_uuid'=> [
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'product_title'=> [
                'type' => 'VARCHAR',
                'constraint' => '225'
            ],
            'product_description'=> [
                'type' => 'TEXT',
            ],
            'product_price'=> [
                'type' => 'DOUBLE',
            ],
            'product_show'=> [
                'type' => 'BOOLEAN',
            ],
            'created_at'=> [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'=> [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at'=> [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('product_id', true);
        $this->forge->createTable('product_ms');
    }

    public function down()
    {
        $this->forge->dropTable('product_ms');
    }
}
