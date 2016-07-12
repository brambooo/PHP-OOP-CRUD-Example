<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 12-7-2016
 * Time: 18:21
 */
// Necessary includes
$pageTitle = "Product toevoegen";
include_once('view/header.php');

// Initialize database connection
include_once('assets/config/database.php');
$db = new Database();

include_once('domain/Category.php');
include_once('domain/Product.php');

// Initialize Category
$categoryObj = new Category($db);
?>

<!-- Main content -->
    <form action="create_product.php" method="post">
        <div class="form-group">
            <label for="name">Naam:</label>
            <input type="name" name="name" class="form-control" >
        </div>
        <div class="form-group">
            <label for="price">Prijs:</label>
            <input type="text" name="price" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Beschrijving:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Categorie:</label>
            <!-- Category select -->
            <input type="text" name="price" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Opslaan</button>
    </form>
<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Alle producten bekijken</a>
</div>
<?php include_once('view/footer.php'); ?>