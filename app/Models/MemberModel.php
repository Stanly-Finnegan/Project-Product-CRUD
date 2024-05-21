<?php 

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model{
  protected $table = 'member_ms';
  protected $primaryKey = 'member_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'member_uuid',
    'member_email',
    'member_password',
    'member_name',
    'member_phone',
    'member_active',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Member::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>