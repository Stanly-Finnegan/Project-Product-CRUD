<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CartItem extends Entity{

  protected $atributes = [
    'cart_item_id' => null,
    'cart_id' => null,
    'product_id' => null,
    'cart_item_uuid' => null,
    'cart_item_quantity' => null,
    'cart_item_price' => null,
    'cart_item_total_price' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'cart_item_total_price' => 'float',
    'cart_item_price' => 'float',

  ];

}

?>