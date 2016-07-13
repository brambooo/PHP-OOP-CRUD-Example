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
$db = new Database();
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
        <th>Naam</th>
        <th>Beschrijving</th>
        <th>Prijs</th>
        <th>Categorie</th>
        <th>Aangemaakt</th>
        <th>Acties</th>
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
            $categoryName = $category->readCategorieNameByID($category_id);
            echo "<td>{$categoryName}</td>";
            echo "<td>{$created}</td>";
            echo "<td>acties</td>";
       echo "/<tr>";
   }
   ?>
</table>
<div class="pull-right">
    <a href="create_product.php" class="btn btn-default">Product toevoegen</a>
</div>
<?php include_once('view/footer.php'); ?>