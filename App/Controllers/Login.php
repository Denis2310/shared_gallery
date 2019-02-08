<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;
use \Core\Session;
use \App\Models\User;

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
		global $session;

		return !$session->is_signed_in()? true : redirect('home');
	}

	/**
	* Function that could be executed after any other method in Home Controller
	*/
	protected function after()
	{

	}

	public function indexAction()
	{
		global $session;

		//Check if user login form is submited
		if (isset($_POST['submit'])) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);

			if($username && $password != '') {
				$user = User::login($username, $password); //User::find()

				if ($user==true) {
					$session->login($user->id, $user->username);
					//Dodati message
					return redirect('home');
				}

				return View::renderTemplate('Auth/login.php');
			}
			//If logged in register to SESSION, if not redirect to login with message
		} else {
			return View::renderTemplate('Auth/Login.php');
		}
	}

}