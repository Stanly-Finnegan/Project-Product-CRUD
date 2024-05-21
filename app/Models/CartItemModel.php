<?php 

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model{
  protected $table = 'cart_item_ms';
  protected $primaryKey = 'cart_item_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'cart_id',
    'product_id',
    'cart_item_uuid',
    'cart_item_quantity',
    'cart_item_price',
    'cart_item_total_price',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\CartItem::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>