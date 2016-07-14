<?php
// Attributes
$pageTitle = "Producten bekijken";

// Necessary includes
include_once('assets/config/database.php');
include_once('assets//Debugging.php');
include_once('domain/Product.php');
include_once('domain/Category.php');
include_once('view/header.php');

// Initialize objects
$db = Database::getInstance();
$product = new Product($db->conn);

// Get all products from the database
$products = $product->readAllCategories();

// TODO: nog afmaken
//$db =
//$pageNr = isset($_GET['page']) ? $_GET['page'] : 1;     // check page number, is not set go to 1
//$productsPerPage = 5;                                  // Set number of products per page.

?>

<!-- Main content -->
<table class="table table-hover table-responsive table-bordered">
    <tr>
        <th class="col-sm-2">Naam</th>
        <th class="col-sm-3">Beschrijving</th>
        <th class="col-sm-1">Prijs</th>
        <th class="col-sm-1">Categorie</th>
        <th class="col-sm-2">Aangemaakt</th>
        <th class="col-sm-3">Acties</th>
    </tr>
   <?php
   // Load products from the database
   foreach($products as $product) {

       // Debugging::printItemAsArray($product);

       // Extract product so we can call them easily with the column names of the database
       extract($product);
       echo "<tr>";
            echo "<td>{$name}</td>";
            echo "<td>{$description}</td>";
            echo "<td>&euro;{$price}</td>";
            // Get category name for the given category id
            $category = new Category($db->conn);
            $categoryName = $category->readCategoryNameByID($category_id);
            echo "<td>{$categoryName}</td>";
            echo "<td>{$created}</td>";
            echo "<td>
                    <a href='update_product.php?id={$id}' class='btn btn-primary'> Bewerken</a>
                    <a href='#' onclick='deleteProduct($id)' class='btn btn-danger'> Verwijderen</a>
                 </td>";
       echo "<tr>";
   }
   ?>
</table>
<div class="pull-right">
    <a href="create_product.php" class="btn btn-default">Product toevoegen</a>
</div>
<?php include_once('view/footer.php'); ?>