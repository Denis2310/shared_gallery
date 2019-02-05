<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;
use \Core\Session;

/**
* Login Controller
*/
class Login extends Controller
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

	public function index()
	{
		//Check if user login form is submited
		if (isset($_POST['submit'])) {

			echo "login form submitted";

			//Validator to validate user login data

			//If logged in register to SESSION, if not redirect to login with message

		} else {
			return View::renderTemplate('Auth/Login.php');
		}
	}

}