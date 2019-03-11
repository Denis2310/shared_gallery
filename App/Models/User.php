<?php
namespace App\Models;

use \Core\Model;
use Image;
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
	* Save user to database
	*
	* @return boolean true if user is registered, otherwise false
	*/
	public function save()
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
	* @return $user User object if user exists, otherwise boolean false
	*/
	static function login($username, $password)
	{
		$db = static::getDB();
		//$sql = 'SELECT * FROM shared_gallery_db.' . self::$db_table . ' WHERE username=?';
		$sql = 'SELECT * FROM ' . self::$db_table . ' WHERE username=?';
		$stmt = $db->prepare($sql);
		$stmt->execute([$username]);

		//IF USER EXISTS CHECK PASSWORD
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
	* Check before registration if user unique data already exists (username, email)
	*
	* @param $db PDO object
	*
	* @return boolean true if both username and email are not in database, otherwise false
	*/
	private function checkIfExists($db)
	{
		$sql = 'SELECT * FROM ' . self::$db_table . ' WHERE username = :username OR email = :email';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->rowCount() == 0 ? true : false;  //to promjenio pa provjeriti da li  to radi umjesto ovog komentiranog gore
	}

	static function deleteAll($user_id)
	{
		$db = static::getDB();
		$sql = 'DELETE FROM users WHERE id=' . $user_id;
		
		if ($db->exec($sql)) {
			$sql = 'DELETE FROM images WHERE user_id=' . $user_id;

			if ($db->exec($sql)) {
				return true;
			}
		}

		return false;
	}
}