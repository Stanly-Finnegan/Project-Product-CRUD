<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity{

  protected $atributes = [
    'product_id' => null,
    'product_uuid' => null,
    'product_title' => null,
    'product_description' => null,
    'product_price' => null,
    'product_show' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'product_show' => 'boolean',
    'product_price' => 'float',

  ];

}

?>