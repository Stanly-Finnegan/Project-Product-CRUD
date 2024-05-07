<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class OrderItem extends Entity{

  protected $atributes = [
    'order_item_id' => null,
    'order_id' => null,
    'product_id' => null,
    'order_item_uuid' => null,
    'order_item_quantity' => null,
    'order_item_total_price' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'order_item_quantity ' => 'INT',
    'order_id ' => 'INT',
    'product_id ' => 'INT',
    'order_item_total_price' => 'float',

  ];

}

?>