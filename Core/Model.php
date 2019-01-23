<?php
namespace Core;

use PDO;
use App\Config;

/**
* Abstract model class
*/
abstract class Model
{
	static function getDB()
	{
		static $db = null;

		if ($db === null) {
			$host = Config::DB_HOST;
			$username = Config::DB_USERNAME;
			$password = Config::DB_PASSWORD;
			$database = Config::DB_NAME;

			try {
				    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
				    // set the PDO error mode to exception
				    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				    echo "Connected successfully";

			    }
			catch(PDOException $e)
			    {
			    	echo "Connection failed: " . $e->getMessage();
			    }
		}

		return $db;		
	}
}