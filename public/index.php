<?php

/*
Add Twig template to project
*/
require dirname(__DIR__) . '/vendor/autoload.php';

/**
* Error and exception handling
*/
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$session = new Core\Session();

/* First way for loading classes 
require "..\Core\Router.php";
require "..\App\Controllers\Home.php";
require "..\App\Controllers\Posts.php";

//Second way for loading classes
spl_autoload_register(function ($class_name) {
	$root  = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class_name) . '.php';
	if (is_readable($file)) {
		  require $file;
	}
});
*/

/**
* Router object
*
* Add routes to Router
*/
$router = new Core\Router();

$router->add_route('', ['controller'=>'Home', 'action'=>'index']);
$router->add_route('login', ['controller'=>'Login', 'action'=>'index']);
$router->add_route('register', ['controller'=>'Register', 'action'=>'index']);
$router->add_route('{controller}/{action}');
$router->add_route('{controller}/{id:\d+}/{action}');
$router->add_route('admin/{action}/{controller}');
$router->add_route('management', ['controller'=>'Management', 'action'=>'index']);
$router->add_route('management/image/{id:\d+}', ['controller'=>'User', 'action'=>'delete_image']);
$router->add_route('myaccount', ['controller'=>'MyAccount', 'action'=>'index']);
$router->add_route('logout', ['controller'=>'Management', 'action'=>'logout']);

$router->dispatch($_SERVER['QUERY_STRING']);