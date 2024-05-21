<?php 

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\MemberModel;
use App\Models\MemberTokenModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class MemberController extends BaseController{

  use ResponseTrait;

  public function loginMember (){
    $post_data = $this->request->getPost();

    $db = db_connect();
    $db->transBegin();

    $memberModel = new MemberModel();
    $memberTokenModel = new MemberTokenModel();
    $cartModel = new CartModel();

 
    $memberData = $memberModel->where('member_email', $post_data['email'])->first();
    // var_dump($memberData);
    // die;

    if($memberData && password_verify($post_data['password'], $memberData->member_password)){
      $memberTokenData = [
        'member_id' => (int)$memberData->member_id,
        'member_token_uuid' => Uuid::uuid4(),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => null,
        'deleted_at' => null
      ];

      $cartData =[
        'member_id' => (int)$memberData->member_id,
        'cart_uuid' => Uuid::uuid4(),
        'cart_total_price' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => null,
        'deleted_at' => null
      ];
      
      if(!$memberTokenModel->insert($memberTokenData)){

        $db->transRollback();
          return $this->fail('Failed to login');
      }

      if(!$cartModel->insert($cartData)){
        $db->transRollback();
        return $this->fail('Failed to login');
      }

      $db->transCommit();
      return $this->respond($memberTokenData['member_token_uuid']);
    }
    else{
      $db->transRollback();
      return $this->fail('Account does not match');
    }
    
  }

  public function registerMember() {

    $validatoin = \Config\Services::Validation();
    $validatoin->setRuleGroup('strongPasswordValidation');

    $post_data = $this->request->getPost();

    if($validatoin->run($post_data) === false){
      return $this->fail(['error' => $validatoin->getErrors(), 'message' => 'Failed to register account']);
    }

    $memberModel = new MemberModel();

    $data = [
      'member_uuid' => Uuid::uuid4(),
      'member_name' => $post_data['name'],
      'member_email' => $post_data['email'],
      'member_password' => password_hash($post_data['password'], PASSWORD_DEFAULT),
      'member_phone' => $post_data['phone'],
      'member_active' => true
    ];

    if(!$memberModel->insert($data)){
      return $this->fail(['error'=> null, 'message'=> 'Failed to register account']);
    }

    return $this->respond('success to register account');





  }

}
?>