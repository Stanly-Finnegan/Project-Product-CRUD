<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// MEMBER ROUTES
$routes->post('/loginMember', 'MemberController::loginMember');
$routes->post('/registerMember', 'MemberController::registerMember');
$routes->get('/getProductMemberData', 'DataMemberController::getProductMemberData');
$routes->get('/getProductMemberDetailData/(:segment)', 'DataMemberController::getProductMemberDetailData/$1');
$routes->post('/addCartMemberItem', 'DataMemberController::addCartMemberItem');
$routes->get('/getCartMemberData', 'DataMemberController::getCartMemberData');
$routes->put('/updateCartMemberData', 'DataMemberController::updateCartMemberData');
$routes->post('/deleteSelectedMemberItem', 'DataMemberController::deleteSelectedMemberItem');
$routes->get('/getCheckoutData', 'DataMemberController::getCheckoutData');
$routes->post('/setMemberOrder', 'DataMemberController::setMemberOrder');
$routes->put('/setConfirmOrder', 'DataMemberController::setConfirmOrder');
$routes->post('/setConfirmPayment', 'DataMemberController::setConfirmPayment');


$routes->group('head', function($routes){
  $routes->get('getProduct', 'Head\DataAdminController::getProduct');
  $routes->post('loginAdmin','Head\AdminController::loginUser');
  $routes->get('checkToken', 'Head\AdminController::checkToken');
  $routes->post('insertProduct', 'Head\DataAdminController::insertProduct');
  $routes->put('changeShow', 'Head\DataAdminController::changeShow');
  $routes->put('updateProduct', 'Head\DataAdminController::updateProduct');
  $routes->delete('deleteProduct/(:segment)', 'Head\DataAdminController::deleteProduct/$1');
  $routes->get('getUpdateData/(:segment)', 'Head\DataAdminController::getUpdateData/$1');
  $routes->post('insertImageProduct', 'Head\DataAdminController::insertImageProduct');
  $routes->get('getImageData/(:segment)', 'Head\DataAdminController::getImageData/$1');
  $routes->put('changeImageShow', 'Head\DataAdminController::changeImageShow');
  $routes->delete('deleteProductImage/(:segment)', 'Head\DataAdminController::deleteProductImage/$1');
  $routes->get('getProductOrderData', 'Head\DataAdminController::getProductOrderData');
  $routes->get('getProductOrderData/(:segment)', 'Head\DataAdminController::getProductOrderDataSearch/$1');
  $routes->post('insertOrder', 'Head\DataAdminController::insertOrder');
  $routes->get('getOrder', 'Head\DataAdminController::getOrder');
  $routes->delete('deleteOrder/(:segment)', 'Head\DataAdminController::deleteOrder/$1');
  $routes->get('getPayment/(:segment)', 'Head\DataAdminController::getPayment/$1');
  $routes->put('updatePaymentStatus', 'Head\DataAdminController::updatePaymentStatus');
  $routes->get('getMember', 'Head\DataAdminController::getMemberData');
  $routes->put('updateMemberStatus', 'Head\DataAdminController::updateMemberStatus');
  $routes->get('getMemberDetail/(:segment)', 'Head\DataAdminController::getMemberDetailData/$1');
  $routes->get('getBank', 'Head\DataAdminController::getBankData');
  $routes->put('updateBankStatus', 'Head\DataAdminController::bankStatusUpdate');
  $routes->get('getBankUpdateData/(:segment)', 'Head\DataAdminController::getBankUpdateData/$1');
  $routes->put('updateBank', 'Head\DataAdminController::updateBank');
  $routes->delete('deleteBank/(:segment)', 'Head\DataAdminController::deleteBank/$1');
  $routes->post('insertBank', 'Head\DataAdminController::insertBank');
});

$routes->group('member', function($routes){
  $routes->get('', 'MemberController::index');
});