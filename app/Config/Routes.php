<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/loginUser','UserController::loginUser');
$routes->get('/checkToken', 'UserController::checkToken');
$routes->get('/getProduct', 'DataController::getProduct');
$routes->post('/insertProduct', 'DataController::insertProduct');
$routes->put('/changeShow', 'DataController::changeShow');
$routes->put('/updateProduct', 'DataController::updateProduct');
$routes->get('/getUpdateData/(:segment)', 'DataController::getUpdateData/$1');
$routes->post('/insertImageProduct', 'DataController::insertImageProduct');
$routes->get('/getImageData/(:segment)', 'DataController::getImageData/$1');
$routes->put('/changeImageShow', 'DataController::changeImageShow');
$routes->delete('/deleteProductImage/(:segment)', 'DataController::deleteProductImage/$1');
$routes->delete('/deleteProduct/(:segment)', 'DataController::deleteProduct/$1');
$routes->get('/getProductOrderData', 'DataController::getProductOrderData');
$routes->get('/getProductOrderData/(:segment)', 'DataController::getProductOrderDataSearch/$1');
$routes->post('/insertOrder', 'DataController::insertOrder');


