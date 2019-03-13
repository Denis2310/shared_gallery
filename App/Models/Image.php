<?php
namespace App\Models;

use \Core\Model;
use PDO;

/**
* Image model
*/
class Image extends Model
{
	protected static $db_table = 'images';
	protected static $db_table_fields = array('user_id', 'path');
	public $id, $user_id, $path;

	/**
	* Save image to database
	*
	* @return boolean true if image was saved, otherwise false
	*/
	public function save()
	{
		$db = static::getDB();

		$sql = 'INSERT INTO ' . self::$db_table . '(' . implode(',', self::$db_table_fields) . ') VALUES(?, ?)';
		$stmt = $db->prepare($sql);
		$stmt->execute([$this->user_id, $this->path]);

		return $stmt? true : false;
	}

	static function delete($image_id)
	{
		$db = static::getDB();
		$sql = 'DELETE FROM ' . self::$db_table . ' WHERE id=' . $image_id;
		
		if ($db->exec($sql)) {
			return true;
		}

		return false;		
	}
}