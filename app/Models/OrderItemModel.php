<?php 

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model{
  protected $table = 'order_item_ms';
  protected $primaryKey = 'order_item_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'order_id',
    'product_id',
    'order_item_uuid',
    'order_item_quantity',
    'order_item_total_price',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\OrderItem::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>