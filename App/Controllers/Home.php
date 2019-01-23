<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;

/**
* Home Controller
*/
class Home extends Controller
{
	/**
	* Function that could be executed before any other method in Home Controller
	*/
	protected function before()
	{

	}

	/**
	* Function that could be executed after any other method in Home Controller
	*/
	protected function after()
	{

	}

	/**
	* Method for Home/index.php view
	*/
	public function indexAction()
	{
		return View::renderTemplate('Home/index.php');
	}
}