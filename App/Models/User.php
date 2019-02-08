<?php
namespace App\Models;

use \Core\Model;
use PDO;

/**
* User model
*/
class User extends Model
{
	protected static $db_table = 'users';
	protected static $db_table_fields = array('username', 'email', 'password');
	public $id, $username, $email, $password;

	/**
	* Save registered user to database
	*
	* @return boolean true if user is registered, otherwise false
	*/
	public function register()
	{
		$db = static::getDB();

		if ($this->checkIfExists($db)) {
			$sql = 'INSERT INTO shared_gallery_db.' . self::$db_table . ' (' . implode(', ', self::$db_table_fields) . ') VALUES (?,?,?)';
			$stmt = $db->prepare($sql);
			$stmt->execute([$this->username, $this->email, $this->password]);

			if ($stmt == true) {
				$this->id = $db->lastInsertId();

				return true;
			}
		}

		return false;
	}

	/**
	* Login function - check if user exists in database
	*
	* @param string $username
	* @param string $password
	*
	* @return array of user data if user exists, boolean false if user not found
	*/
	static function login($username, $password)
	{
		$db = static::getDB();
		$sql = 'SELECT * FROM shared_gallery_db.' . self::$db_table . ' WHERE username=:username';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $username);
		$stmt->execute();

		//IF USER EXIST CHECK PASSWORD
		if ($stmt->rowCount() > 0) {
			$db_user = $stmt->fetch(PDO::FETCH_ASSOC);
			$db_user_password = $db_user['password'];
			
			if (password_verify($password, $db_user_password)) {
				$user = new User();
				$user->username =  $db_user['username'];
				$user->email = $db_user['email'];
				$user->id = $db_user['id'];

				return $user;
			}
		}
		
		return false;
	}

	/**
	* Check if username or email exists in database - for registration
	*
	* @param $db PDO object
	*
	* @return boolean
	*/
	private function checkIfExists($db)
	{
		$sql = 'SELECT * FROM shared_gallery_db.' . self::$db_table . ' WHERE username = :username OR email = :email';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->rowCount() == 0 ? true : false;  //to promjenio pa provjeriti da li  to radi umjesto ovog komentiranog gore
	}	
}