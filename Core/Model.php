<?php
namespace Core;

use App\Config;
use PDO;

/**
 * Abstract model class
 */
abstract class Model
{
    /**
     * Initialize PDO database connection
     *
     * @return $db PDO connection
     */
    public static function getDB()
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
                    $sql = "CREATE DATABASE " . $database;
                    $sql2 = "USE " . $database;

                    $db->exec($sql);
                    $db->exec($sql2);

                    //After creating database, create tables
                    $users = "CREATE TABLE `users` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `username` varchar(255) NOT NULL,
                            `email` varchar(255) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            PRIMARY KEY (`id`)
                            )";
                    $images = "CREATE TABLE `images` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `user_id` varchar(255) NOT NULL,
                             `path` varchar(255) NOT NULL,
                             `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             PRIMARY KEY (`id`)
                            )";

                    $db->exec($users);
                    $db->exec($images);
                } else {
                    $db->exec('USE ' . $database);
                }
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return $db;
    }

    /**
     * Get all results for selected database table
     *
     * @return $result Associative array
     */
    public static function findAll()
    {
        $objects_array = array();
        $db = static::getDB();
        $sql = 'SELECT * FROM ' . static::$db_table;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result_set = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //return $result;
        foreach ($result_set as $result) {
            $object = static::instantation($result);
            $objects_array[] = $object;
        }

        return $objects_array;
    }

    /**
     * Get result from table by specified ID
     *
     * @param $id Integer
     * @return $result Associative array
     */
    public static function findById($id)
    {
        $db = static::getDB();
        $sql = 'SELECT * FROM ' . static::$db_table . ' WHERE id= ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]); //Promjenjeno sa dodavanja varijabli u $sql da se dodavaju u execute
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //return $result;
        $object = static::instantation($result);
        return $object;
    }

    public static function sql($sql)
    {
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function instantation($result)
    {
        $class = get_called_class();
        $the_object = new $class;

        foreach ($result as $attribute => $value) {
            if (property_exists($the_object, $attribute)) {
                $the_object->$attribute = $value;
            }
        }

        return $the_object;
    }
}
