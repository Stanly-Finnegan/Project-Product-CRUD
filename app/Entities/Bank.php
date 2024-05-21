<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Bank extends Entity{

  protected $atributes = [
    'bank_id' => null,
    'bank_uuid' => null,
    'bank_name' => null,
    'bank_account_number' => null,
    'bank_order' => null,
    'bank_show' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'bank_order' => 'INT',
    'bank_show' => 'boolean'
  ];

}

?>