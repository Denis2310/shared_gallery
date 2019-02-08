<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;
use \Core\Validator;
use \App\Models\User;

/**
* Registration Controller
*/
class Register extends Controller
{
	/**
	* Function that could be executed before any other method in Register Controller
	*/
	protected function before()
	{
		global $session;

		return !$session->is_signed_in()? true : redirect('home');
	}

	/**
	* Function that could be executed after any other method in Register Controller
	*/
	protected function after()
	{
		//Check if user is not logged in before allow access to Register controller methods
		if(!isset($_SESSION['user']) && !isset($_SESSION['username'])) {
			return true;
		}

		return redirect('home');
	}

	/**
	* Registration form view
	*/
	public function indexAction()
	{
		global $session;

		//Check if register form is submitted
		if (isset($_POST['submit'])) {
			$validated = Validator::validateRegistration($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password-confirm']);
			//Pozvati validator klasu i odraditi validaciju
			if ($validated === true) {
				$user = new User();

				$user->username = $_POST['username'];
				$user->email = $_POST['email'];

				$password = password_hash($_POST['password'], PASSWORD_ARGON2I);
				$user->password = $password;
				
				if ($user->register() == true) {

					$session->login($user->id, $user->username);
					return redirect('home');
				}

				return View::renderTemplate('Auth/register.php');
				
			} else {
				print_r($validated);
			}

		//AKO JE KORISNIK REGISTRIRAN SPREMITI GA U SESSION I REDIREKTATI NA HOME, U SUPROTNOM VRAĆAJ NA REGISTER
		} else {
			return View::renderTemplate('Auth/register.php');
		}
	}

}