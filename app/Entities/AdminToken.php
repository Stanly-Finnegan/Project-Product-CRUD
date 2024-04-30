<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdminToken extends Entity{

  protected $atributes = [
    'admin_token_id' =>  null,
    'admin_id' => null,
    'admin_token_uuid' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'admin_id' => 'INT'
  ];

}

?>