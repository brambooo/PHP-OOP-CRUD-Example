<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 14-7-2016
 * Time: 09:53
 */

//echo "<pre>" . print_r($_POST, true) . "</pre>";
//exit();

include_once('assets/config/database.php');
$db = Database::getInstance();

if(isset($_POST)) {

    $id = $_POST['id'];
    // Delete product from the database
    $isDeleted = $db->deleteRecord('product', $id);

    if($isDeleted) {
       return true;
    }

}