<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentConfirmationInitial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_confirmation_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'bank_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'member_id' =>[
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'payment_confirmation_uuid' =>[
                'type' => 'CHAR',
                'constraint' => '36',
            ],
            'payment_confirmation_transfer_date' =>[
                'type' => 'DATE',

            ],
            'payment_confirmation_bank_name' =>[
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'payment_confirmation_account_name' =>[
                'type' => 'VARCHAR',
                'constraint' => '225',
            ],
            'payment_confirmation_account_number' =>[
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'payment_confirmation_total_payment' =>[
                'type' => 'DOUBLE',

            ],
            'payment_confirmation_receipt' =>[
                'type' => 'VARCHAR',
                'constraint' => '225',
            ],
            'payment_confirmation_status' =>[
                'type' => 'INT',

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
        $this->forge->addKey('payment_confirmation_id', true);
        $this->forge->createTable('payment_confirmation_ms');
    }

    public function down()
    {
        $this->forge->dropTable('payment_confirmation_ms');
    }
}
