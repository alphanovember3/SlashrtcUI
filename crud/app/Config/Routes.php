<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['get','post'],'/', 'Home::index');
$routes->post('/saveUser','Home::saveUser');
$routes->get('/getSingleUser/(:num)','Home::getSingleUser/$1');
$routes->post('/updateUser','Home::updateUser');
$routes->post('/deleteUser','Home::deleteUser');
$routes->post('/filter','Home::filter');
$routes->post('/campfilter','Campcontroller::filter');
$routes->post('/deleteMultiUser','Home::deleteMultiUser');
$routes->get('/downloadfile','Home::downloadfile');
$routes->get('/getChatUsername','Home::getChatUsername');
$routes->match(['get','post'],'/uploadfile','Home::uploadfile');   

// Authentication routes

$routes->match(['get','post'],'/login','Auth::login');
// $routes->get('/register','Home::register');
$routes->match(['get','post'],'/register','Auth::register');

$routes->get('/logout','Auth::logout');
$routes->get('/campaign','Campcontroller::index');
$routes->get('/dashboard','Campcontroller::dashboard');
$routes->post('/saveUsercamp','Campcontroller::saveUser');
$routes->post('/updateUsercamp','Campcontroller::updateUsercamp');
$routes->get('/getSingleUsercamp/(:num)','campcontroller::getSingleUser/$1');
$routes->post('/deleteUsercamp','campcontroller::deleteUser');

$routes->post('/search', 'Home::search');
$routes->get('/chat', 'Home::chatApp');

//Reports ->Routes

$routes->get('/getSummaryReport/(:num)','Reports::getSummaryReport/$1');
$routes->match(['get','post'],'/showReport/(:num)', 'Reports::showReport/$1');
$routes->get('/getLoggerReport/(:num)', 'Reports::getLoggerReport/$1');
$routes->get('/showSummaryReport/(:num)', 'Reports::showSummaryReport/$1');