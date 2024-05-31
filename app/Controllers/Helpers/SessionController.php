<?php 

namespace App\Controllers\Helpers;

use App\Models\AdminModel;
use App\Models\AdminTokenModel;
use App\Models\MemberTokenModel;

class SessionController extends HelpersController{

  protected $memberId = 0;
  protected $adminId = 0;

  protected function _checkAuthorization ($type) {
    $bearerToken = $this->request->getHeaderLine('Authorization');

    if((string) $bearerToken !== '' && (string) $bearerToken !== null){
      $explodeBearerToken = explode(' ', $bearerToken);

      if($explodeBearerToken[0] === 'Bearer'){
        $jwt = $explodeBearerToken[1];
      }
    }

    if(strtolower($type) === 'member'){
      $memberTokenModel = new MemberTokenModel();
      $memberToken = $memberTokenModel->where('member_token_uuid', $jwt)->first();
  
      if( !$jwt || $memberToken === NULL || $memberToken === '') {
        return false;
      }
  
      $this->memberId = $memberToken->member_id;
    }
    else if(strtolower($type) === 'admin'){
      $adminTokenModel = new AdminTokenModel();
      $adminToken = $adminTokenModel->where('admin_token_uuid', $jwt)->first();
  
      if( !$jwt || $adminToken === NULL || $adminToken === '') {
        return false;
      }

      $this->adminId = $adminToken->admin_id;
    }

    return true;

  }
  
}

?>