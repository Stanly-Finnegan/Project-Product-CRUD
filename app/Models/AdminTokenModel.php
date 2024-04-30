<?php 

namespace App\Models;

use CodeIgniter\Model;

class AdminTokenModel extends Model{
  protected $table = 'admin_token_trs';
  protected $primaryKey = 'admin_token_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'admin_id',
    'admin_token_uuid',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\AdminToken::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>