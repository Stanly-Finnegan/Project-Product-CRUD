<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BankAcountNameInitial extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bank_ms',[
            'bank_account_name' =>[
                'type' => 'VARCHAR',
                'constraint' => '225'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bank_ms', 'bank_account_name');
        
    }
}
