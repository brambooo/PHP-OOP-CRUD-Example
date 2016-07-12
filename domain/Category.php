<?php

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
    public function createCategory() {

    }

    public function readAllCategories() {

    }

    public function readCategorieByID($id) {

    }


}