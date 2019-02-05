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
	* Function that could be executed before any other method in Posts Controller
	*/
	protected function before()
	{
		//TU STAVITI DA AKO JE KORISNIK LOGIRAN NE MOŽE PRISTUPITI
	}

	/**
	* Function that could be executed after any other method in Posts Controller
	*/
	protected function after()
	{

	}

	/**
	* Registration form view
	*/
	public function indexAction()
	{
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

				if ($user->save()) {
					echo "User registered";
				} else {
					echo "User with selected username and/or password is already registered.";
				}
			} else {
				print_r($validated);
			}

		//AKO JE KORISNIK REGISTRIRAN SPREMITI GA U SESSION I REDIREKTATI NA HOME, U SUPROTNOM VRAĆAJ NA REGISTER
		} else {
			return View::renderTemplate('Auth/register.php');
		}
	}

}