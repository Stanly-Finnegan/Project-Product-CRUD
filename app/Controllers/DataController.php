<?php 

namespace App\Controllers;

use App\Entities\OrderItem;
use App\Entities\Product;
use App\Models\AdminTokenModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\DataCaster\Cast\BooleanCast;
use Config\Database;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Stmt\Echo_;
use Ramsey\Uuid\Type\Integer;
use Ramsey\Uuid\Uuid;

use function PHPUnit\Framework\isNull;

class DataController extends BaseController{

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

  public function insertProduct () {

    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }

    $post_data = $this->request->getPost();

    $productModel = new ProductModel();

    if($post_data['status'] === 'show'){
      $booleanProduct_show = true;
    }
    else{
      $booleanProduct_show = false;
    }

    $floatProduct_price = (float)$post_data['price'];

    $data = [
      'product_uuid' => Uuid::uuid4(),
      'product_title' => $post_data['title'],
      'product_description' => $post_data['description'],
      'product_price' => $floatProduct_price,
      'product_show' => $booleanProduct_show,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => null,
      'deleted_at' => null
    ];

    if(!$productModel->insert($data) ){
      return $this->fail('Fail to add product');
    }

    return $this->respond('Successfully added a product');
  }

  public function getProduct (){

    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }
    
    $productModel = new ProductModel();

    $rawData = $productModel->findAll();

    $resultData = [];

    foreach($rawData as $dataRow){
      array_push($resultData,
      [
        'id' => $dataRow->product_uuid,
        'title'=> $dataRow->product_title,
        'price' => $dataRow->product_price,
        'show' => $dataRow->product_show,
        'status' => $dataRow->product_show === true ?  'Show':'Hide',
      ]
      );
    }

    return $this->respond($resultData);

  }

  public function changeShow (){
    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }
    $put_data = $this->request->getRawInput();

    // echo($put_data['show']);

    $productModel = new ProductModel();
    $data = [
      'product_show' => $put_data['show'] === "true" ? true : false ,
    ];
    
    // var_dump($put_data);
    // // echo($data['product_show']);
    // die;
  
    if($productModel->where('product_uuid', $put_data['id'])->update(null, $data)){
      return  $this->respond('Successfully Changed Show Status!');
    }
    else{
      return $this->fail('Failed to Change Show Status');
    }

  }

  public function updateProduct (){
    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }
    $put_data = $this->request->getRawInput();
    // var_dump($put_data);
    // // echo($data['product_show']);
    // die;

    $productModel = new ProductModel();
    $data = [
      'product_title' => $put_data['title'],
      'product_description' => $put_data['description'],
      'product_price' => $put_data['price'],
      'product_show' => $put_data['status'] === "show" ? true : false ,
    ];
    

  
    if($productModel->where('product_uuid', $put_data['id'])->update(null, $data)){
      return  $this->respond('Successfully update data!');
    }
    else{
      return $this->fail('Failed to update data');
    }


  }

  public function getUpdateData ($id) {
    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }
    $productModel = new ProductModel();

    $rawData = $productModel->select('product_title, product_description, product_price, product_show')->where('product_uuid', $id)->first();

    $data = [
      'title' => $rawData->product_title,
      'description' => $rawData->product_description,
      'price' => $rawData->product_price,
      'status' => $rawData->product_show === true? 'show':'hide',
    ];

    if(!$data){
        return $this->fail('No Data Found');
    }

    return $this->respond($data);
    
  }

  public function insertImageProduct (){
    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }

    $db = db_connect();
    $db->transBegin();
    $post_data = $this->request->getPost();
    $post_files = $this->request->getFileMultiple('files');
    // var_dump($post_files);die;
    $path = './uploads/images/';

    $productModel = new  ProductModel();
    $productImageModel = new ProductImageModel();
    $productData = $productModel->where('product_uuid', $post_data['id'])-> first();

    if(!is_dir($path)){ 
      mkdir($path,0755,true);
    }

    $failedData = [];
    

    foreach($post_files as $data){
      if($data === null || $data->hasMoved() || $data === ''){
        return $this->fail('Failed to insert Image');
      }
        $newname = $data->getRandomName(); 
        
        if(!$data->move($path,$newname)){
          continue;
        }    

        $imageMaxData = $productImageModel->selectMax('product_image_order')->where('product_id', $productData->product_id)->first();
        $imageOrder = $imageMaxData->product_image_order + 1;

        $imageData = [
          'product_id' => $productData->product_id,
          'product_image_uuid' => Uuid::uuid4(),
          'product_image' => $newname,
          'product_image_order' => $imageOrder,
          'product_image_show' => $post_data['status'] === 'show'? true : false,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => null,
          'deleted_at' => null
        ];

        if(!$productImageModel->insert($imageData)){
          array_push($failedData, $imageData);
          continue;
        }


    }
    // If there is failed data on image uploading process, rollback the transaction.
    if(count($failedData) > 0){
      $db->transRollback();
      return $this->fail('Failed to insert new images');
    }

    $db->transCommit();
    return $this->respond('Success Insert All images');
  }

  public function getImageData($id) {
    $productImageModel = new  ProductImageModel();
    $productModel = new ProductModel();

    $productData = $productModel->where('product_uuid', $id)->first();
    $rawData = $productImageModel->where('product_id', $productData->product_id)->findAll();

    if($productData === null || $rawData == null || $rawData === '') {
      return $this->fail('Failed  to find product data');
    }
    

    $result =[];
    foreach($rawData as $data){
      array_push($result,[
        'id' => $data->product_image_uuid,
        'image' => $data->product_image,
        'show' => $data->product_image_show? true:false,
      ]);
    }
    return $this->respond(['title' => $productData->product_title, 'result'=> $result]);
  }

  public function changeImageShow (){
    if(!$this->checkToken()){
      return $this->fail('Invalid Token');
    }
    $put_data = $this->request->getRawInput();

    // var_dump($put_data);
    // // echo($data['product_show']);
    // die;
    $productImageModel = new ProductImageModel();
    $data = [
      'product_image_show' => $put_data['show'] === "true"? true : false ,
    ];
    
    // var_dump($data['product_image_show']);
    // // echo($data['product_show']);
    // die;
  
    if($productImageModel->where('product_image_uuid', $put_data['id'])->update(null, $data)){
      return  $this->respond('Successfully Changed Show Status!');
    }
    else{
      return $this->fail('Failed to Change Show Status');
    }

  }

  public function deleteProductImage ($id){
    $productImageModel = new  ProductImageModel();
    $path = './uploads/images/';
    $productImageData = $productImageModel->where('product_image_uuid', $id)->first();


    if($productImageModel->where('product_image_uuid', $id)->delete()){
      unlink($path . $productImageData->product_image);
      return $this->respond('Successfully Deleted Image.');
    }

    return $this->fail("Faild to Delete the Image");
  }


  public function deleteProduct ($id){
    $db = db_connect();
    $db->transBegin();
    $path = './uploads/images/';
    $productModel = new ProductModel();
    $productImageModel = new ProductImageModel();

    $productData = $productModel->where('product_uuid', $id)->first();
    $productImageData = $productImageModel->where('product_id', $productData->product_id)->findAll();
    if(
      $productModel->where('product_uuid', $id)->delete() 
      &&
      $productImageModel->where('product_id', $productData->product_id)->delete()) {

        foreach($productImageData as $data){
          unlink($path. $data->product_image);
        }
        $db->transCommit();
        return $this->respond('Successfully deleted product and related images.');

    }
    $db->transRollback();
    return  $this->fail('Error deleting product or related images. Please try again');

  }

  public function getProductOrderData () {
    $productModel = new ProductModel();
    $productImageModel = new ProductImageModel();

    $productData = $productModel->findAll();
    $result = [];
    foreach ($productData as $value) {
      $productImageData = $productImageModel->select('product_image')->where('product_id', $value->product_id)->findAll();

      $tempProductData = [
        'title' => $value->product_title,
        'price' => $value->product_price,
        'id' => $value->product_uuid,
        'quantity' => null,

      ];
      $tempImageData = [];

      foreach ($productImageData as $data) {
        array_push($tempImageData,[
          'image' => $data->product_image
        ]);
      }

      array_push($result,[
        'product' => $tempProductData,
        'image' => $tempImageData
      ]);
    }

    return $this->respond($result);
  }

  public function getProductOrderDataSearch ($data) {
    $productModel = new ProductModel();
    $productImageModel = new ProductImageModel();

    $productData = $productModel->like('product_title', $data)->findAll();
    $result = [];
    foreach ($productData as $value) {
      $productImageData = $productImageModel->select('product_image')->where('product_id', $value->product_id)->findAll();

      $tempProductData = [
        'title' => $value->product_title,
        'price' => $value->product_price,
        'id' => $value->product_uuid,
        'quantity' => null,
      ];
      $tempImageData = [];

      foreach ($productImageData as $data) {
        array_push($tempImageData,[
          'image' => $data->product_image
        ]);
      }

      array_push($result,[
        'product' => $tempProductData,
        'image' => $tempImageData
      ]);
    }

    return $this->respond($result);
  }

  public function insertOrder (){
    $db = db_connect();

    $db->transBegin();
    $post_data = $this->request->getPost();
    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $productModel = new ProductModel();

    $newData = json_decode($post_data['data'],true);


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
      'order_uuid' => Uuid::uuid4(),
      'order_number' => $order_number,
      'order_total_price' => $post_data['total'],
      'order_status' => 1,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => null,
      'deleted_at' => null
    ];

    if(!$orderModel->insert($orderData)){
      return $this->fail('Fail to add order');
    }

    $orderID = $orderModel->where('order_number', $order_number)->first();
    foreach ($newData as $item) {
      $productData = $productModel->where('product_uuid', $item['id'])->first();
      $orderItemData = [
        'order_id' => $orderID->order_id,
        'product_id' => $productData->product_id,
        'order_item_uuid' => Uuid::uuid4(),
        'order_item_quantity' => $item['quantity'],
        'order_item_total_price' => $item['price'],
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
    return $this->respond('Success to add order');

  }

  public function getOrder (){
    $orderModel = new OrderModel();
    $orderData = $orderModel->findAll();

    

    $result = [];
    foreach($orderData as $data){
      $date = explode( ' ' ,$data->created_at);
      array_push($result,[
        'order_number' => $data->order_number,
        'date_time' => $date[0]. ' '. $date[1],
        'total_price' => $data->order_total_price,
        'status' => $data->order_status === '1' ? 'Paid':'Pending' ,
        'id' => $data->order_uuid
      ]);
    }


    return $this->respond($result);

  }

  public function deleteOrder ($data){
    $orderModel = new OrderModel();
    
    if(!$orderModel->where('order_uuid', $data)->delete()){
      return $this->fail('Failed to delete the data');
    }

    return $this->respond('Success delete data');

  }

}

 ?>