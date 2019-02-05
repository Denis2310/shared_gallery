<?php
namespace Core;

class Validator
{
	static function validateRegistration($username, $email, $password, $password_confirmation)
	{
		$message = [];

		//Validation logic here
		if (($username && $email && $password) != '') {
			if (!preg_match('/^[A-Za-z0-9]{3,}$/', $username)) {
				$message[] = 'Username is invalid. Minimum 3 characters required, and only alphanumerics.';
			}
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$message[] = 'Email address is not valid.';
			}
			if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/', $password)) {
				$message[] = 'Password should contain at least one lowercase, 
				uppercase letter and number. No spaces allowed. Minimum 6 characters';
			}
			if ($password != $password_confirmation) {
				$message[] = 'Password confirmation failed.';
			}
		} else {
			$message[] = 'All registration fields are required.';
		}

		if (!empty($message)) {
			return $message;
		} else {
			return true;     //// tu sam stavio zavrsiti password validaciju i onda provjeriti sve
		}
	}

	static function validateLogin($username, $password)
	{
		$message = '';

		//Validation logic here

		return true;
	}
}