<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Order extends Entity{

  protected $atributes = [
    'order_id' => null,
    'order_uuid' => null,
    'order_number' => null,
    'order_total_price' => null,
    'order_status' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'order_status ' => 'INT',
    'order_price' => 'float',

  ];

}

?>