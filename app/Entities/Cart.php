<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Cart extends Entity{

  protected $atributes = [
    'cart_id' => null,
    'member_id' => null,
    'cart_uuid' => null,
    'cart_total_price' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'cart_total_price' => 'float',
  ];

}

?>