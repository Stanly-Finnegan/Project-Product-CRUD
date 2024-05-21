<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressColumnInitial extends Migration
{
    public function up()
    {
        $this->forge->addColumn('order_ms',[
            'order_address' =>[
                'type' => 'VARCHAR',
                'constraint' => '225'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('order_ms', 'order_address');
    }
}
