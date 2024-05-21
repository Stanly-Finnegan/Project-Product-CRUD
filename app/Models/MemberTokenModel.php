<?php 

namespace App\Models;

use CodeIgniter\Model;

class MemberTokenModel extends Model{
  protected $table = 'member_token_trs';
  protected $primaryKey = 'member_token_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'member_id',
    'member_token_uuid',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\MemberToken::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>