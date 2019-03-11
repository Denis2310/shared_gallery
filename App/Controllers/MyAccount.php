<?php
namespace App\Controllers;

use \Core\Controller;
use \Core\View;
use \Core\Validator;
use \App\Models\Image;
use \App\Models\User;
/**
* MyAccount Controller
*/
class MyAccount extends Controller
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

	/**
	* Account management View, Edit password or delete account
	*
	*/
	public function indexAction() 
	{
		global $session;
		$user = User::findById($session->user_id);
		
		//edit user password if edit form was submitted
		if (isset($_POST['edit-user'])) {

			if (password_verify($_POST['old-password'], $user['password'])) {			
				$new_password = $_POST['new-password'];
				$confirm_password = $_POST['password-confirm'];

				$result = Validator::validatePasswordEdit($new_password, $confirm_password);

				if ($result === true) {
					//SAVE EDITED USER PASSWORD HERE
				} else {
					//password validation failed, returned message errors
					$session->message($result);
					return redirect('myaccount');
				}
			} else {
				//old password is not correct
				$session->message('Wrong password!');
				return redirect('myaccount');
			}
		}

		if (isset($_POST['delete-user'])) {

			// logic for deleting user and his related images
		}

		//if everything is okay, return myaccount view with user edited data
		return View::renderTemplate('User/myaccount.php', ['user' => $user]);
	}


	public function deleteAction() 
	{
		global $session;

		if (User::deleteAll($session->user_id)) {
			$user_images = $_SERVER['DOCUMENT_ROOT'] . '/shared_gallery/public/images/' . $session->user_id;
			rrmdir($user_images);
			$session->logout();
		}

		return redirect('/shared_gallery/public');
	}
}