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
		global $session;
		
		return !$session->is_signed_in()? true : redirect('management');
	}

	/**
	* Function that could be executed after any other method in Home Controller
	*/
	protected function after()
	{

	}

	public function indexAction()
	{
		return View::renderTemplate('home.php');
	}
}