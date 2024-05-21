<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MemberToken extends Entity{

  protected $atributes = [
    'member_token_id' =>  null,
    'member_id' => null,
    'member_token_uuid' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null
  ];

  // protected $casts =[
  //   'member_id' => 'INT'
  // ];

}

?>