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
    public function createRecordForTable($tableName, $columnValues) {

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

    public function deleteOneRecord($tableName, $id) {}

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
            $query .= '' . $key . "=" . $this->columnValidate($value) . ' ';

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
    
    private function columnValidate($columnValue) {
        return is_numeric($columnValue) == true ? $columnValue : "'{$columnValue}'";
    }

}