<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/loginAdmin','AdminController::loginUser');
$routes->get('/checkToken', 'AdminController::checkToken');
$routes->get('/getProduct', 'DataAdminController::getProduct');
$routes->post('/insertProduct', 'DataAdminController::insertProduct');
$routes->put('/changeShow', 'DataAdminController::changeShow');
$routes->put('/updateProduct', 'DataAdminController::updateProduct');
$routes->get('/getUpdateData/(:segment)', 'DataAdminController::getUpdateData/$1');
$routes->post('/insertImageProduct', 'DataAdminController::insertImageProduct');
$routes->get('/getImageData/(:segment)', 'DataAdminController::getImageData/$1');
$routes->put('/changeImageShow', 'DataAdminController::changeImageShow');
$routes->delete('/deleteProductImage/(:segment)', 'DataAdminController::deleteProductImage/$1');
$routes->delete('/deleteProduct/(:segment)', 'DataAdminController::deleteProduct/$1');
$routes->get('/getProductOrderData', 'DataAdminController::getProductOrderData');
$routes->get('/getProductOrderData/(:segment)', 'DataAdminController::getProductOrderDataSearch/$1');
$routes->post('/insertOrder', 'DataAdminController::insertOrder');
$routes->get('/getOrder', 'DataAdminController::getOrder');
$routes->delete('/deleteOrder/(:segment)', 'DataAdminController::deleteOrder/$1');

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
