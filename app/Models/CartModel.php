<?php 

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model{
  protected $table = 'cart_ms';
  protected $primaryKey = 'cart_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'member_id',
    'cart_uuid',
    'cart_total_price',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Cart::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>