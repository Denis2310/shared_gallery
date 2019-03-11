<?php
namespace Core;

class Validator
{
	static function validateRegistration($username, $email, $password, $password_confirmation)
	{
		$message = '';
		$username = trim($username);
		$email = trim($email);
		$password = trim($password);
		
		//Validation logic here
		if (($username && $email && $password) != '') {
			if (!preg_match('/^[A-Za-z0-9_]{3,}$/', $username)) {
				$message .= 'Username is invalid. Minimum 3 characters required, and only alphanumerics.';
			}
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$message .= 'Email address is not valid.';
			}
			if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/', $password)) {
				$message .= 'Password should contain at least one lowercase, 
				uppercase letter and number. No spaces allowed. Minimum 6 characters';
			}
			if ($password != $password_confirmation) {
				$message .= 'Password confirmation failed.';
			}
		} else {
			$message .= 'All registration fields are required.';
		}

		return $message != ''? $message : true;
	}

	static function validateFile(array $file)
	{
		$message = '';
		$is_valid_image = getimagesize($file['tmp_name']);
		$image_name = $file['name'];
		$image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

		if ($is_valid_image != false) {
			if ($image_type != 'jpg' && $image_type != 'png') {
				$message .= 'Sorry, only JPG and PNG formats are allowed.';
			}
		} else {
			$message .= 'Invalid file.';
		}

		return $message != ''? $message : true;
	}

	static function validatePasswordEdit($password, $confirm_password) {

		$message = '';
		$password = trim($password);
		$confirm_password = trim($confirm_password);

		if ($password === $confirm_password) {
			if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/', $password)) {
				$message .= 'Password should contain at least one uppercase character and 
				at least one number. No spaces are allowed. Minimum 6 characters';
			}
		} else {
			$message .= 'Password is not confirmed.';
		}

		return $message != ''? $message : true;
	}

}