<?php

/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 12-7-2016
 * Time: 17:52
 */
class Product
{
    // Attributes
    private $db;                            // database connection
    private $tableName = "product";        // database table name

    // Object properties
    private $id;
    private $name;
    private $price;
    private $description;
    private $categorie_id;
    private $created;

    // Constructor
    public function __construct($db)
    {
        $this->db = $db;    // setup db connection, see Database class for more information
    }

    // Methods
    public function createProduct() {
        // clean all object properties
        $this->name = htmlentities($this->name);
        $this->price = htmlentities($this->price);
        $this->description = htmlentities($this->description);
        $this->categorie_id = htmlentities($this->categorie_id);
        $this->created = htmlentities($this->created);

        // Query
        $query = "INSERT INTO {$this->tableName} SET name := ?, price := ?, description := ?, category_id := ?";

        // Prepare statement
        $stmt = $this->db->prepare($query);

        // Bind attribues to placeholders
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->price);
        $stmt->bindParam(3, $this->description);
        $stmt->bindParam(4, $this->categorie_id);

        // Validate if create product has been successful
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
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

    public function readCategorieNameByID($id) {
        $query = "SELECT * FROM {$this->tableName} WHERE id = ? limit 0,1";

        // Prepare statement
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);

        // If the statement was succesful return the data
        if($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['name'];
        }
    }
}