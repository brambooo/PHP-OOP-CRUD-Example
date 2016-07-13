<?php
include_once('assets/config/database.php');
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 12-7-2016
 * Time: 17:52
 */
class Category
{
    // Attributes
    private $db;                            // database connection
    private $tableName = "category";        // database table name

    private $id;
    private $name;

    // Constructor
    public function __construct($db)
    {
        $this->db = $db;    // setup db connection, see Database class for more information
    }

    // Methods
    public function createCategory($categoryName) {
        $query = "INSERT INTO `category` (`name`) VALUES ('$categoryName')";
    }

    /**
     * readAllCategories()
     * read all the categories from the database and return them
     * @return mixed
     */
    public function readAllCategories() {
        $query = "SELECT * FROM {$this->tableName}";

        // Prepare query
        $stmt = $this->db->prepare($query);

        // If the statement was successful return the data
        if($stmt->execute()) {
            // return all the categories as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function readCategoryNameByID($id) {
        $query = "SELECT * FROM {$this->tableName} WHERE id = ? limit 0,1";

        // Prepare statement
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);

        // If the statement was succesful return the data
        if($stmt->execute()) {
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = $row['name'];
            return $name != null ? $name : 'Geen';
        }
    }


}