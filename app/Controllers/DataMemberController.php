<?php 

namespace App\Controllers;

use App\Entities\OrderItem;
use App\Entities\Product;
use App\Entities\ProductImage;
use App\Models\AdminTokenModel;
use App\Models\BankModel;
use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\MemberModel;
use App\Models\MemberTokenModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentConfirmationModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use Config\Database;
use Ramsey\Uuid\Uuid;

use function PHPUnit\Framework\isEmpty;

class DataMemberController extends BaseController{
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

  public function getProductMemberData(){
    $productModel = new ProductModel();
    $productImageModel = new ProductImageModel();

    $productData = $productModel->findAll();

    $result = [];

    foreach($productData as $data){
      $productImageData = $productImageModel->where('product_id', $data->product_id)->first();

      array_push( $result,
      [
        'id' => $data->product_uuid,
        'title' => $data->product_title,
        'price' => $data->product_price,
        'image' => $productImageData->product_image
      ]);

    }

    return $this->respond($result);

  }
  
  public function getProductMemberDetailData($data){
    $productModel = new ProductModel();
    $productImageModel = new ProductImageModel();

    $productData = $productModel->where('product_uuid', $data)->first();
    $productImageData = $productImageModel->where('product_id', $productData->product_id)->findAll();

    $imageHighlight = null;
    $imageData = [];
    $count = 0;
    foreach($productImageData as $data){
      $count === 0? 
      $imageHighlight  = $data->product_image 
      : 
      array_push($imageData,$data->product_image);

      $count++;

    }

    $result = [
      'title' => $productData->product_title,
      'description' => $productData->product_description,
      'price' => $productData->product_price,
      'highlight' => $imageHighlight,
      'image' => $imageData
    ];

    return $this->respond($result);

  }

  public function addCartMemberItem(){
    $jwt = $this->_checkAuthorization();
    $post_data = $this->request->getPost();

    $db = db_connect();
    $db->transBegin();

    $memberTokenModel = new MemberTokenModel();

    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
 
    $memberID = $memberAuthData->member_id;

    $productModel = new ProductModel();
    $cartModel = new CartModel();
    $cartItemModel = new CartItemModel();

    $productData = $productModel->where('product_uuid', $post_data['id'])->first();
 
    if(!isEmpty($memberID) || !isEmpty($productData)){
      return $this->fail('Failed add item to cart 1');
    }

    $cartData = $cartModel->where('member_id', $memberID)->first();

    $currTotalPrice = (float)$post_data['quantity'] * (float)$productData->product_price;

    $cartItemData = [
      'cart_id' => $cartData->cart_id,
      'product_id' => $productData->product_id,
      'cart_item_uuid' => Uuid::uuid4(),
      'cart_item_quantity' => $post_data['quantity'],
      'cart_item_price' => $productData->product_price,
      'cart_item_total_price' => $currTotalPrice,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => null,
      'deleted_at' => null
    ];

    $cartItemOldData = $cartItemModel
    ->where('product_id', $productData->product_id )
    ->where('cart_id', $cartData->cart_id)
    ->first();


    if($cartItemOldData !== null){      
      $updatedQuantity = (int)$cartItemOldData->cart_item_quantity + (int)$post_data['quantity'];
      $updatedTotalPrice = (float)$updatedQuantity * (float)$productData->product_price;

      $updatedData=[
        'cart_item_quantity' => $updatedQuantity ,
        'cart_item_total_price' => $updatedTotalPrice,
      ];

      if($cartItemModel->where('product_id', $productData->product_id)->update(null,$updatedData)){
        $updatedcartItemData = $cartItemModel
        ->where('cart_id', $cartData->cart_id)
        ->findAll();

        $updatedCartTotalPrice = 0;
        foreach($updatedcartItemData as $data){
          $updatedCartTotalPrice += $data->cart_item_total_price;
        }
        $cartUpdateData = [
          'cart_total_price' => $updatedCartTotalPrice
        ];

        if($cartModel->where('cart_id', $cartData->cart_id)-> update(null, $cartUpdateData)){
          $db->transCommit();
          return $this->respond('Success update item to cart');
        }
      }

      $db->transRollback();
      return $this->fail('fail to update item to cart');
    }



    if($cartItemModel->insert($cartItemData)){

      $updatedcartItemData = $cartItemModel
      ->where('cart_id', $cartData->cart_id)
      ->findAll();

      $updatedCartTotalPrice = 0;
      foreach($updatedcartItemData as $data){
        $updatedCartTotalPrice += (int)$data->cart_item_total_price;
      }
      $cartUpdateData = [
        'cart_total_price' => $updatedCartTotalPrice
      ];

      if($cartModel->where('cart_id', $cartData->cart_id)-> update(null, $cartUpdateData)){
        $db->transCommit();
        return $this->respond('Success add item to cart');
      }
    }

    $db->transRollback();
    return $this->fail('Failed add item to cart 2');
  }

  public function getCartMemberData(){
    $jwt = $this->_checkAuthorization();

    $memberTokenModel = new MemberTokenModel();
    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
    $memberID = $memberAuthData->member_id;
    
    $cartModel = new CartModel();
    $cartItemModel = new CartItemModel();
    $cartData = $cartModel->where('member_id', $memberID)->first();
    $cartItemData = $cartItemModel->where('cart_id', $cartData->cart_id)->findAll();

    $productImageModel = new ProductImageModel();
    $productModel = new ProductModel();
    $temp = [];
    foreach($cartItemData as $data){
    $productImage = $productImageModel->where('product_id', $data->product_id)->first();
    $productData = $productModel->where('product_id', $data->product_id)->first();
      array_push($temp,[
        'image' => $productImage->product_image,
        'id' => $productData->product_uuid,
        'title' => $productData->product_title,
        'price' => $productData->product_price,
        'totalPrice' => $data->cart_item_total_price,
        'quantity' => $data->cart_item_quantity,
      ]);
    }

    $result = [
      'cartTotalPrice' => $cartData->cart_total_price,
      'result' => $temp
    ];

    return $this->respond($result);


  }

  public function updateCartMemberData(){
    $jwt = $this->_checkAuthorization();
    $put_data = $this->request->getRawInput();

    $cartItemModel = new CartItemModel();
    $cartModel = new CartModel();
    $productModel = new ProductModel();

    $memberTokenModel = new MemberTokenModel();
    $db = db_connect();
    $db->transBegin();

    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
 
    $memberID = $memberAuthData->member_id;

    $productData = $productModel->where('product_uuid', $put_data['id'])->first();
    $cartItemData = $cartItemModel->where('product_id', $productData->product_id)->first();
    $cartData = $cartModel->where('member_id', $memberID)->first();

    $data =[
      'cart_item_quantity' => $put_data['quantity'],
      'cart_item_total_price'=> (float)$cartItemData->cart_item_price * (float)$put_data['quantity']
    ];

    if($put_data['quantity'] < 1){
      if($cartItemModel
      ->where('product_id', $productData->product_id)
      ->where('cart_id', $cartData->cart_id)
      ->delete()){
        $db->transCommit();
        return $this->respond('quantity 0, item deleted');
      }
      else{
        return $this->fail('Quanity 0, fail to delete data');
      }
    }

    if( $cartItemModel
        ->where('product_id', $productData->product_id)
        ->where('cart_id', $cartData->cart_id)
        ->update(null,$data))
    {
      $updatedcartItemData = $cartItemModel
      ->where('cart_id', $cartData->cart_id)
      ->findAll();

      $updatedCartTotalPrice = 0;
      foreach($updatedcartItemData as $data){
        $updatedCartTotalPrice += (int)$data->cart_item_total_price;
      }
      $cartUpdateData = [
        'cart_total_price' => $updatedCartTotalPrice
      ];
      if($cartModel->where('cart_id', $cartData->cart_id)-> update(null, $cartUpdateData)){
        $db->transCommit();
        return $this->respond('Success update item to cart');
      }
    }

    $db->transRollback();
    return $this->fail('fail to update cart');

  }

  public function deleteSelectedMemberItem (){
    $post_data = $this->request->getPost('data');
    $jwt = $this->_checkAuthorization();

    $db = db_connect();
    $db->transBegin();

    $memberTokenModel = new MemberTokenModel();
    $productModel = new ProductModel();
    $cartItemModel = new CartItemModel();
    $cartModel = new CartModel();

    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
    $memberID = $memberAuthData->member_id;
    $cartData = $cartModel->where('member_id', $memberID)->first();
    $cartID = $cartData->cart_id;
    $flag = 0;

    // Cart Item Delete Data
    foreach($post_data as $data){
      $productData = $productModel->where('product_uuid', $data)->first();
      if($cartItemModel
          ->where('product_id', $productData->product_id)
          ->where('cart_id', $cartID)
          ->delete())
      {
        $flag += 1;
      }
    }
    //{{END}} Cart Item Delete Data


    // Cart Data Update
    if($flag === count($post_data)){
      $updatedItemCartData = $cartItemModel->where('cart_id', $cartID)->findAll();
      $updatedCartTotalPrice = 0;
      foreach($updatedItemCartData as $data){
        $updatedCartTotalPrice += (int)$data->cart_item_total_price;
      }

      $updatedCartData = [
        'cart_total_price' => $updatedCartTotalPrice
      ];

      if($cartModel->where('cart_id', $cartID)->update(null,$updatedCartData)){
        $db->transCommit();
        return $this->respond('Success to delete Data');
      }
    }
    //{{END}} Cart Data Update


    $db->transRollback();
    return $this->fail('Fail to delete data');



  }

  public function getCheckoutData(){
    $jwt = $this->_checkAuthorization();

    // Member Data Processing
    $memberTokenModel = new MemberTokenModel();
    $memberModel = new MemberModel();
    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
    $memberID = $memberAuthData->member_id;
    $memberData = $memberModel->where('member_id', $memberID)->first();
    //{{END}} Member Data Processing

    // Cart Data Processing
    $cartModel = new CartModel();
    $cartData = $cartModel->where('member_id', $memberID)->first();
    $cartTotalPrice = $cartData->cart_total_price;
    //{{END}} Cart Data Processing

    // Bank Data Processing
    $bankModel = new BankModel();
    $bankData = $bankModel->findAll();
    $newBankData = [];
    foreach($bankData as $data){
      array_push($newBankData, [
        'id' => $data->bank_uuid,
        'name' => $data->bank_name,
        'number' => $data->bank_account_number
      ]);
    }
    // {{END}} Bank Data Processing

    $result = [
      'email' => $memberData->member_email,
      'name' => $memberData->member_name,
      'totalPayment' => $cartTotalPrice,
      'bankList' => $newBankData
    ];

    return $this->respond($result);

  }

  public function setMemberOrder(){
    $jwt = $this->_checkAuthorization();
    $db = db_connect();
    $db->transBegin();

    $post_data = $this->request->getPost();
    $memberTokenModel = new MemberTokenModel();
    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();
    $memberID = $memberAuthData->member_id;

    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $cartModel = new CartModel();
    $cartData = $cartModel->where('member_id', $memberID)->first();
    $cartID = $cartData->cart_id;
    


    $today = date('Ymd');
    $lastOrder = $orderModel->like('order_number', $today)->first();
    if($lastOrder === null || $lastOrder === ''){
      $order_number = $today . '001';
    }
    else{
      $lastNumber = intval(substr($lastOrder->order_number, -3));
      $lastNumber = $lastNumber +1;
      $lastNumber = sprintf('%03d', $lastNumber);
      $order_number = $today. $lastNumber;
    }

    $orderData = [
      'member_id' => $memberID,
      'order_uuid' => Uuid::uuid4(),
      'order_number' => $order_number,
      'order_total_price' => $post_data['totalPayment'],
      'order_address' => $post_data['address'],
      'order_status' => 0,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => null,
      'deleted_at' => null
    ];

    if(!$orderModel->insert($orderData)){
      return $this->fail('Fail to add order');
    }

    $cartItemModel  = new CartItemModel();

    $cartItemData = $cartItemModel->where('cart_id', $cartID)->findAll();

    $orderData = $orderModel->where('order_number', $order_number)->first();
    foreach ($cartItemData as $item) {
      $orderItemData = [
        'order_id' => $orderData->order_id,
        'product_id' => $item->product_id,
        'order_item_uuid' => Uuid::uuid4(),
        'order_item_quantity' => $item->cart_item_quantity,
        'order_item_total_price' => $item->cart_item_total_price,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => null,
        'deleted_at' => null
      ];

      if(!$orderItemModel->insert($orderItemData)){
        $db->transRollback();
        return $this->fail('Fail to add order');
      }
    }
    $db->transCommit();
    return $this->respond($orderData->order_number);

  }

  public function setConfirmOrder(){
    $jwt = $this->_checkAuthorization();
    $put_data = $this->request->getRawInput();

    $memberTokenModel = new MemberTokenModel();
    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();

    
    $orderModel = new OrderModel();
    $cartModel = new CartModel();
    $cartItemModel = new CartItemModel();
    $cartData = $cartModel->where('member_id', $memberAuthData->member_id)->first();
    
    $db = db_connect();
    $db->transBegin();

    if($orderModel->where('order_number', $put_data['order'])->update(null,['order_status' => 1])){
      if($cartItemModel->where('cart_id', $cartData->cart_id)->delete()){
        $updatedcartItemData = $cartItemModel
        ->where('cart_id', $cartData->cart_id)
        ->findAll();

        $updatedCartTotalPrice = 0;
        foreach($updatedcartItemData as $data){
          $updatedCartTotalPrice += $data->cart_item_total_price;
        }

        if($cartModel->where('cart_id', $cartData->cart_id)->update(null,['cart_total_price'=> $updatedCartTotalPrice])){
          $db->transCommit();
          return $this->respond('success to update order status');
        }
      }
    }

    $db->transRollback();
    return $this->fail('failed to update order status');
  }

  public function setConfirmPayment(){
    $jwt = $this->_checkAuthorization();
    $post_data = $this->request->getPost();
    $image_data = $this->request->getFile('files');
    $newData = json_decode($post_data['data'],true);
    $path = './uploads/receipt';

    if(!is_dir($path)){ 
      mkdir($path,0755,true);
    }

    $paymentConfirmationModel = new PaymentConfirmationModel();


    $memberTokenModel = new MemberTokenModel();
    $memberAuthData = $memberTokenModel->where('member_token_uuid', $jwt)->first();

    $memberModel = new MemberModel();
    $memberData = $memberModel->where('member_id', $memberAuthData->member_id)->first();

    $orderModel = new OrderModel();
    $orderData = $orderModel->where('order_number', $newData['order'])->first();

    $bankModel = new BankModel();
    $bankData = $bankModel->where('bank_uuid', $newData['bank']['id'])->first();

    if($image_data === null || $image_data->hasMoved() || $image_data === ''){
      return $this->fail('Failed to add receipt image');
    }

    $newname = $image_data->getRandomName(); 

    if(!$image_data->move($path,$newname)){
      return $this->fail('Failed to add receipt image');
    }    

    $data = [
      'order_id' => $orderData->order_id,
      'bank_id' => $bankData->bank_id,
      'member_id' => $memberAuthData->member_id,
      'payment_confirmation_uuid' => Uuid::uuid4(),
      'payment_confirmation_transfer_date' => $newData['date'],
      'payment_confirmation_bank_name' => $newData['bankName'],
      'payment_confirmation_account_name' => $newData['accountName'],
      'payment_confirmation_account_number' => $newData['accountNumber'],
      'payment_confirmation_total_payment' => $orderData->order_total_price,
      'payment_confirmation_receipt' => $newname,
      'payment_confirmation_status' => 1,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => null,
      'deleted_at' => null
    ];

    if($paymentConfirmationModel->insert($data)){
      return $this->respond('success to confirm payment');
    }

    unlink($path.'/'.$newname);
    return $this->fail('failed to update order status');
  }

 

}

?>