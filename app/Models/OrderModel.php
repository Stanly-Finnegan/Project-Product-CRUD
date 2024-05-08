<?php 

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model{
  protected $table = 'order_ms';
  protected $primaryKey = 'order_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'order_uuid',
    'order_number',
    'order_total_price',
    'order_status',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Order::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>