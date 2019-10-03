<?php

class DataBase
{
    /**
     * Instance of PDO
     * @var $PDOInstance PDO
     */
    private static $PDOInstance;

    /**
     * DataBase constructor.
     */
    private function __construct() { }

    /**
     * Access to PDO
     * @return PDO
     */
    public static function getInstance()
    {
        if (empty(self::$PDOInstance)) {

            $dsn = "pgsql:host=test-pgsql;dbname=wallet";
            $user = "test";
            $password = "test";

            try {
                self::$PDOInstance = new PDO($dsn, $user, $password);
            } catch (PDOException $e) {
                die("PDO CONNECTION ERROR: " . $e->getMessage());
            }
        }
        return self::$PDOInstance;
    }
}