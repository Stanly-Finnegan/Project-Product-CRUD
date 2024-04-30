<?php 

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model{
  protected $table = 'admin_ms';
  protected $primaryKey = 'admin_id';
  protected $useAutoIncrement = true;
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'admin_uuid',
    'admin_email',
    'admin_password',
    'admin_name',
    'admin_active',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $returnType = \App\Entities\Admin::class;


  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';
}


?>