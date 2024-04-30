<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model{
  protected $table = 'product_ms';
  protected $primaryKey = 'product_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'product_uuid',
    'product_title',
    'product_description',
    'product_price',
    'product_show',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Product::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>