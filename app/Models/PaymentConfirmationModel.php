<?php 

namespace App\Models;

use CodeIgniter\Model;

class PaymentConfirmationModel extends Model{
  protected $table = 'payment_confirmation_ms';
  protected $primaryKey = 'payment_confirmation_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'order_id',
    'bank_id',
    'member_id',
    'payment_confirmation_uuid',
    'payment_confirmation_transfer_date',
    'payment_confirmation_bank_name',
    'payment_confirmation_account_name',
    'payment_confirmation_account_number',
    'payment_confirmation_total_payment',
    'payment_confirmation_receipt',
    'payment_confirmation_status',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\PaymentConfirmation::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>