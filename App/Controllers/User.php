<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;
/**
* User Controller
*/
class User extends Controller
{
	/**
	* Function that could be executed before any other method in Home Controller
	*/
	protected function before()
	{
		global $session;

		return $session->is_signed_in()? true : redirect('/shared_gallery/public'); 
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

	public function logout()
	{
		global $session;
		$session->logout();

		return redirect('/shared_gallery/public');
	}
}