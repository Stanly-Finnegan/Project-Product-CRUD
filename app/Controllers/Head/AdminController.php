<?php 

namespace App\Controllers\Head;
use App\Controllers\BaseController;

use App\Models\AdminModel;
use App\Models\AdminTokenModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class AdminController extends BaseController{

  use ResponseTrait;

  function _checkAuthorization() {
    $bearerToken = $this->request->getHeaderLine('Authorization');

    if((string) $bearerToken !== '' && (string) $bearerToken !== null){
      $explodeBearerToken = explode(' ', $bearerToken);

      if($explodeBearerToken[0] === 'Bearer'){
        return $explodeBearerToken[1];
      }
    }
    return false;
  }

  public function checkToken () {
    $jwt = $this->_checkAuthorization();

    $adminTokenModel = new AdminTokenModel();
    $adminToken = $adminTokenModel->select('admin_token_uuid')->where('admin_token_uuid', $jwt)->first();

    if( !$jwt || $adminToken === NULL || $adminToken === '') {
      return $this->fail('Invalid Token');
    }

    return $this->respond('Valid Token');

  }

  public function loginUser () {

    $post_data = $this->request->getPost();


    $adminModel = new AdminModel();
    $adminTokenModel = new AdminTokenModel();
 
    $adminData = $adminModel->where('admin_email', $post_data['email'])->first();
    // var_dump($adminData);
    // die;

    if($adminData && password_verify($post_data['password'], $adminData->admin_password)){
      $adminTokenData = [
        'admin_id' => $adminData->admin_id,
        'admin_token_uuid' => Uuid::uuid4(),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => null,
        'deleted_at' => null
      ];
      
      if($adminTokenModel->insert($adminTokenData)){
        return $this->respond($adminTokenData['admin_token_uuid']);
      }
    }
    else{
      return $this->fail('Account does not match');
    }

  }

}

?>