<?php
namespace Core;

class Session
{
	private $signed_in = false;
	public $user_id;
	public $username;

	public function __construct()
	{

	}

	public function is_signed_in()
	{
		return $this->signed_in;
	}

	public function check_login()
	{
		
	}

	public function logout()
	{
		unset($this->user_id);
		unset($this->username);
		$this->signed_in = false;
	}


	public function login($user)
	{
		if ($user) {
			$this->user_id = $user->id;
			$this->username = $user->username;
			$this->signed_in = true;
		}
	}

}

