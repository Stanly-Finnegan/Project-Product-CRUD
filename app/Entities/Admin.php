<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Admin extends Entity{

  protected $atributes = [
    'admin_id' => null,
    'admin_uuid' => null,
    'admin_email' => null,
    'admin_password' => null,
    'admin_name' => null,
    'admin_active' => false,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  protected $casts =[
    'admin_active' => 'boolean'
  ];

}

?>