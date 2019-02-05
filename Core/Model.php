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
				    $db = new PDO("mysql:host=$host", $username, $password);
				    $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
				    $result = $db->query($sql);

				    //If database does not exists, create it
				    if ($result->fetchColumn() == 0) {
				    	$sql = "CREATE DATABASE shared_gallery_db";
				    	$db->exec($sql);
				    } else {
				    	$db->exec('USE ' . $database);
				    }
				    // set the PDO error mode to exception
				    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    }
			catch(PDOException $e)
			    {
			    	echo "Connection failed: " . $e->getMessage();
			    }
		}

		return $db;		
	}

	static function findAll()
	{
		$db = static::getDB();
		$sql = 'SELECT * FROM ' . static::$db_table;
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
}