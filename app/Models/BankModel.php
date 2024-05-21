<?php 

namespace App\Models;

use CodeIgniter\Model;

class BankModel extends Model{
  protected $table = 'bank_ms';
  protected $primaryKey = 'bank_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'bank_uuid',
    'bank_name',
    'bank_account_number',
    'bank_order',
    'bank_show',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Bank::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>