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

    private static $_instance = null;  // singleton instance (hold the class instance)
    private static $connection;

    private static $DB_HOST = "localhost";
    private static $DB_NAME = "php_oop_crud_project";
    private static $DB_USER = "root";
    private static $DB_PASS = "";

    /**
     * Constructor
     * Database connection is established in the private constructor, to prevent multiple object initialisation.
     */
    private function __construct()
    {
        try {
            // Initialize PDO database
            $this->conn = new PDO("mysql:host=" . self::$DB_HOST . ";dbname=" . self::$DB_NAME, self::$DB_USER, self::$DB_PASS);
        } catch(PDOException $e) {
            echo "Foutmelding connectie met de database: </br>";
            echo $e->getMessage();
        }
    }

    /**
     * getInstance()
     * The Database object is created from within the class itself
     * only if the class has no instance.
     * @return instance
     */
    public static function getInstance() {
        if(self::$_instance == null) {
            // No instance, then create one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function getConnection() {
        return static::$connection;
    }

    /**
     * __clone()
     * is an empty magic method to prevent duplication of connection
     */
    private function __clone() { }

    // Methods

    public function createRecord($tableName, $columns) {

        // Prepare query
        $query = "INSERT INTO {$tableName} SET ";

        $i  = 1;
        $length = count($columns);
        // Loop column (as associative array, with key value pairs) into the query (Dynamic query)
        foreach($columns as $key => $value) {

            // Append column with name and value to query
            $query .= '' . $key . '=' . $this->columnTypeValidate($value);

            // Add comma to query if it isn't the last item
            $i < $length ? $query .= ', ' : $query .= '';

            // increase iterator with one
            $i++;
        } // end loop

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Execute query
        // Validate is INSERT has been successful, if so return true
        if($stmt->execute()) {
            return true;
        }
    }

    /**
     * readRecordFromTableByID()
     * read a specific record from a database table.
     * @param $tableName    name from the table
     * @param $id           id of the item in the table
     * @return              record as an associative array.
     */
    public function readRecordFromTableByID($tableName, $id) {
        // Query
        $stmt = $this->conn->prepare("SELECT * FROM {$tableName} WHERE id = {$id}");
        if($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    public function readAllRecords($tableName) {

    }

    /**
     * @param $tableName
     * @param $id
     * @param $columns
     */
    public function updateRecord($tableName, $id, $columns) {
        // Create query
        $query = "UPDATE {$tableName} SET ";

        $i = 1;                     // start at one
        $length = count($columns);  // get the length of the columns in the database of the given table
        foreach($columns as $key => $value) {
            // Check if $value is numeric or just a string value (see columnValidate method)
            $query .= '' . $key . "=" . $this->columnTypeValidate($value);

            // Add a comma if it isn't the last item
            $i < $length ? $query .= ", " : $query .= "";
            // Increase i by 1
            $i++;
        }
        $query .= " WHERE id = {$id}";

        // Prepare and execute query
        $stmt = $this->conn->prepare($query);
        if($stmt->execute()) {
            // Validate if update has been successful
            if($stmt->rowCount() > 0) {
                return true;
            }
        }
    }

    public function deleteRecord($tableName, $id) {


        $query = "DELETE FROM {$tableName} WHERE id = {$id}";

        // Prepare query
        $stmt = $this->conn->prepare($query);

        // Execute query
        if($stmt->execute()) {
            return true;
        }
    }

    /**
     * columnTypeValidate()
     * is a private method to check which data type is used. For strings add quotes around the $columnValue. However, for a numeric $columnValue none quotes are added.
     * @param $columnValue is the column value.
     * @return the modified column value with or without quotes.
     */
    private function columnTypeValidate($columnValue) {
        return is_numeric($columnValue) == true ? $columnValue . ' ' : "'{$columnValue}' ";
    }

}