<?php

/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 12-7-2016
 * Time: 17:52
 */
class Database
{
    // Attributes
    private static $DB_HOST = "localhost";
    private static $DB_NAME = "php_oop_crud_project";
    private static $DB_USER = "root";
    private static $DB_PASS = "";
    public $conn;

    /**
     * Database constructor.
     * Create a connection with the database
     */
    public function __construct()
    {
        try {
            // Initialize PDO database
            $this->conn = new PDO("mysql:host=" . self::$DB_HOST . ";dbname=" . self::$DB_NAME, self::$DB_USER, self::$DB_PASS);
        } catch(PDOException $pdoE) {
            echo "Foutmelding connectie met de database: </br>";
            echo $pdoE->getMessage();
        }
    }

    // Methods
    // Useful methods will be added later.

}