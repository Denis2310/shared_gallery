<?php
namespace App\Models;

use \Core\Model;
use PDO;

/**
* Post model
*/
class Post extends Model
{
	/**
	* Show all posts
	*
	* @return array $result Array of posts
	*/
	public static function all()
	{
		$db = static::getDB();
	    $query = $db->query('SELECT * FROM posts');
	    $result = $query->fetchAll(PDO::FETCH_ASSOC);

	    return $result;
	}
}