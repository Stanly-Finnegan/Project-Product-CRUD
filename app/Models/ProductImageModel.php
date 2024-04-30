<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model{
  protected $table = 'product_image_ms';
  protected $primaryKey = 'product_image_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'product_id',
    'product_image_uuid',
    'product_image',
    'product_image_order',
    'product_image_show',
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