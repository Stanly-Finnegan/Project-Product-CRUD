<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PaymentConfirmation extends Entity{

  protected $atributes = [
    'payment_confirmation_id' => null,
    'order_id' => null,
    'bank_id' => null,
    'member_id' => null,
    'payment_confirmation_uuid' => null,
    'payment_confirmation_transfer_date' => null,
    'payment_confirmation_bank_name' => null,
    'payment_confirmation_account_name' => null,
    'payment_confirmation_account_number' => null,
    'payment_confirmation_total_payment' => null,
    'payment_confirmation_receipt' => null,
    'payment_confirmation_status' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'paymeny_confirmation_show' => 'boolean',
    'paymeny_confirmation_total_payment' => 'float',
    // 'payment_confirmation_transfer_date' => 'date',


  ];

}

?>