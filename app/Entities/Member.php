<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Member extends Entity{

  protected $atributes = [
    'member_id' => null,
    'member_uuid' => null,
    'member_email' => null,
    'member_password' => null,
    'member_name' => null,
    'member_phone' => null,
    'member_active' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'member_active' => 'boolean'
  ];

}

?>