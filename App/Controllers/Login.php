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

		return !$session->is_signed_in()? true : redirect('/shared_gallery/public');
	}

	/**
	* Function that could be executed after any other method in Home Controller
	*/
	protected function after()
	{

	}

	/**
	* Show login view
	*
	* @return View login.php or redirects to management.php view if logged in
	*/
	public function indexAction()
	{
		global $session;

		//Check if user login form is submited
		if (isset($_POST['submit'])) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);

			if($username && $password != '') {
				$user = User::login($username, $password); //User::find()

				if ($user == true) {
					$session->login($user->id, $user->username);
					$session->message('You are successfully logged in!');
					return redirect('management');
				}
				
				$session->message('Username and/or password are incorrect');
				return redirect('login');
			}

			$session->message('All fields are required.');
			return redirect('login');
		}
		
		return View::renderTemplate('Auth/Login.php');
	}

}