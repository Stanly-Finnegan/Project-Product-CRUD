<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductImage extends Entity{

  protected $atributes = [
    'product_image_id' =>  null,
    'product_id' => null,
    'product_image_uuid' => null,
    'product_image' => null,
    'product_image_order' => null,
    'product_image_show' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'product_image_show' => 'boolean',
  ];

}

?>