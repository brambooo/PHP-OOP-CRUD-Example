<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 13-7-2016
 * Time: 18:41
 */

// Attributes
$pageTitle = "Producten bewerken";

// Necessary includes
include_once('assets/config/database.php');
include_once('assets//Debugging.php');
include_once('domain/Product.php');
include_once('domain/Category.php');
include_once('view/header.php');

// Initialize objects
$db = new Database();
$product = new Product($db->conn);

// Try to get the product for editting
if(isset($_GET['id'])) {
    $productID = $_GET['id'];

    $productFromDB = $db->readRecordFromTableByID($product->tableName, $productID);
    Debugging::printItemAsArray($productFromDB);

} else {
    // Show error message
    ?>
    <div class="alert alert-success">
        <strong>Foutmelding!</strong> Het producten met het opgegeven nummer is niet gevonden. Probeer het nog eens met een ander nummer.<button onclick="navigateBack()">Terug</button>
    </div>
    <?php
}

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
            $categoryName = $category->readCategoryNameByID($category_id);
            echo "<td>{$categoryName}</td>";
            echo "<td>{$created}</td>";
            echo "<td>
                    <a href='update_product.php?id={$id}' class='btn btn-primary'> Bewerken</a>
                    <a href='#' onclick='deleteProduct($id)' class='btn btn-danger'> Verwijderen</a>
                 </td>";
            echo "/<tr>";
        }
        ?>
    </table>
    <div class="pull-right">
        <a href="create_product.php" class="btn btn-default">Product toevoegen</a>
    </div>
    <script>
        // functions
        function navigateBack() {
            window.history.back();
        }
    </script>
<?php include_once('view/footer.php'); ?>