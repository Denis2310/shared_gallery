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
	* @return boolean
	*/
	public function save()
	{
		$db = static::getDB();

		if ($this->checkUser($db)) {
			$sql = 'INSERT INTO shared_gallery_db.' . self::$db_table . ' (' . implode(', ', self::$db_table_fields) . ') VALUES (?,?,?)';
			$stmt = $db->prepare($sql);
			$stmt->execute([$this->username, $this->email, $this->password]);

			return $stmt ? true : false;
		}

		return false;
	}

	/**
	* Check if user already exists in database
	*
	* @param $db PDO object
	* @return boolean
	*/
	private function checkUser($db)
	{
		$sql = 'SELECT * FROM shared_gallery_db.' . self::$db_table . ' WHERE username = :username OR email = :email';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return false;
		}

		return true;
	}	
}