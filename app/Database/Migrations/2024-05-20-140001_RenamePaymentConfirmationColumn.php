<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenamePaymentConfirmationColumn extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('payment_confirmation_ms',[
            'payment_confirmation_name' =>[
                'name' => 'payment_confirmation_bank_name',
                'type' => 'VARCHAR',
                'constraint' => '100'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('payment_confirmation_ms',[
            'payment_confirmation_bank_name' =>[
                'name' => 'payment_confirmation_name',
                'type' => 'VARCHAR',
                'constraint' => '100'
            ]
        ]);
    }
}
